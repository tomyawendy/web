<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Core\Controller;
use App\Repositories\MediaRepository;
use App\Services\ActivityLogService;
use App\Services\UploadService;

class MediaController extends Controller
{
    public function index(): void
    {
        $filters = [
            'type' => (string) $this->request->query('type', ''),
            'q' => trim((string) $this->request->query('q', '')),
        ];
        $this->view('admin/media/index', [
            'items' => (new MediaRepository($this->db))->all($filters),
            'filters' => $filters,
            'metaTitle' => 'Media Library',
        ], 'layouts/admin');
    }

    public function upload(): void
    {
        if (!verify_csrf($this->request->input('_csrf'))) {
            redirect_with_flash(admin_url('media'), 'error', session_expired_message());
        }

        try {
            $type = (string) $this->request->input('type', 'images');
            $media = (new UploadService())->store($this->request->file('media_file'), $type);
            if ($media === null) {
                redirect_with_flash(admin_url('media'), 'error', no_file_selected_message());
            }
            $media['alt_text'] = trim((string) $this->request->input('alt_text', ''));
            $id = (new MediaRepository($this->db))->create($media);
            (new ActivityLogService($this->db))->log($_SESSION['admin']['id'] ?? null, 'upload', 'media', $id, 'Uploaded ' . $media['file_name']);
            redirect_with_flash(admin_url('media'), 'success', 'Media uploaded successfully.');
        } catch (\RuntimeException $exception) {
            redirect_with_flash(admin_url('media'), 'error', $exception->getMessage());
        }
    }

    public function delete(): void
    {
        if (!verify_csrf($this->request->input('_csrf'))) {
            redirect_with_flash(admin_url('media'), 'error', session_expired_message());
        }

        $id = (int) $this->request->input('id', 0);
        $repo = new MediaRepository($this->db);
        $media = $repo->find($id);
        if ($id <= 0 || $media === null) {
            redirect_with_flash(admin_url('media'), 'error', 'Please choose a valid media item.');
        }

        $path = (string) ($media['file_path'] ?? '');
        $relativeUploadPath = preg_replace('#^assets/uploads/#', '', $path);
        if ($relativeUploadPath !== null && $relativeUploadPath !== $path) {
            $filePath = upload_path($relativeUploadPath);
            $uploadRoot = realpath(upload_path());
            $resolvedFile = realpath($filePath);
            $uploadRootPrefix = $uploadRoot === false ? '' : rtrim($uploadRoot, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
            if ($uploadRoot !== false && $resolvedFile !== false && str_starts_with($resolvedFile, $uploadRootPrefix)) {
                @unlink($resolvedFile);
            }
        }

        $repo->delete($id);
        (new ActivityLogService($this->db))->log($_SESSION['admin']['id'] ?? null, 'delete', 'media', $id, 'Deleted media ' . ($media['file_name'] ?? $path));
        redirect_with_flash(admin_url('media'), 'success', 'Media item deleted successfully.');
    }
}
