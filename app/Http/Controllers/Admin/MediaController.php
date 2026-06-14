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
        $this->view('admin/media/index', [
            'items' => (new MediaRepository($this->db))->all(),
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
            $id = (new MediaRepository($this->db))->create($media);
            (new ActivityLogService($this->db))->log($_SESSION['admin']['id'] ?? null, 'upload', 'media', $id, 'Uploaded ' . $media['file_name']);
            redirect_with_flash(admin_url('media'), 'success', 'Media uploaded successfully.');
        } catch (\RuntimeException $exception) {
            redirect_with_flash(admin_url('media'), 'error', $exception->getMessage());
        }
    }
}
