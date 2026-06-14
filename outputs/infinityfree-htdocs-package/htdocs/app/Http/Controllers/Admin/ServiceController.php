<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Core\Controller;
use App\Repositories\ServiceRepository;
use App\Services\ActivityLogService;
use PDOException;

class ServiceController extends Controller
{
    public function index(): void
    {
        $this->view('admin/services/index', [
            'items' => (new ServiceRepository($this->db))->allAdmin(),
            'metaTitle' => 'Service Cards',
        ], 'layouts/admin');
    }

    public function create(): void
    {
        $this->form();
    }

    public function edit(string $id): void
    {
        $this->form((int) $id);
    }

    public function save(): void
    {
        if (!verify_csrf($this->request->input('_csrf'))) {
            redirect_with_flash(admin_url('services'), 'error', session_expired_message());
        }

        $service = [
            'id' => $this->request->input('id') ?: null,
            'slug' => trim((string) $this->request->input('slug')),
            'icon' => trim((string) $this->request->input('icon')),
            'cover_image' => trim((string) $this->request->input('cover_image')),
            'status' => (string) $this->request->input('status', 'draft'),
            'sort_order' => (int) $this->request->input('sort_order', 0),
        ];

        $translations = [];
        foreach (array_keys(config('app.locales', [])) as $locale) {
            $translations[] = [
                'locale' => $locale,
                'title' => (string) $this->request->input("title_{$locale}"),
                'summary' => (string) $this->request->input("summary_{$locale}"),
                'content' => (string) $this->request->input("content_{$locale}"),
                'seo_title' => (string) $this->request->input("seo_title_{$locale}"),
                'seo_keywords' => (string) $this->request->input("seo_keywords_{$locale}"),
                'seo_description' => (string) $this->request->input("seo_description_{$locale}"),
            ];
        }

        $repo = new ServiceRepository($this->db);
        try {
            $id = $repo->save($service, $translations);
        } catch (PDOException $exception) {
            $message = is_duplicate_key_error($exception)
                ? 'This service slug is already in use.'
                : 'We could not save the service card. Please try again.';
            redirect_with_flash(admin_url('services'), 'error', $message);
        }
        (new ActivityLogService($this->db))->log($_SESSION['admin']['id'] ?? null, 'save', 'services', $id, 'Saved service ' . $service['slug']);
        redirect_with_flash(admin_url('services'), 'success', 'Service card saved successfully.');
    }

    private function form(?int $id = null): void
    {
        $item = $id ? (new ServiceRepository($this->db))->find($id) : null;
        if ($id !== null && !$item) {
            redirect_with_flash(admin_url('services'), 'error', content_not_found_message());
        }

        $this->view('admin/services/form', [
            'item' => $item,
            'metaTitle' => $id ? 'Edit Service Card' : 'Create Service Card',
        ], 'layouts/admin');
    }
}
