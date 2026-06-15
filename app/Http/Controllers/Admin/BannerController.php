<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Core\Controller;
use App\Repositories\BannerRepository;
use App\Services\ActivityLogService;
use PDOException;

class BannerController extends Controller
{
    public function index(): void
    {
        $this->view('admin/banners/index', [
            'items' => (new BannerRepository($this->db))->allAdmin(),
            'metaTitle' => 'Banners',
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
            redirect_with_flash(admin_url('banners'), 'error', session_expired_message());
        }

        $banner = [
            'id' => $this->request->input('id') ?: null,
            'image' => trim((string) $this->request->input('image')),
            'link' => trim((string) $this->request->input('link')),
            'status' => (string) $this->request->input('status', 'draft'),
            'sort_order' => (int) $this->request->input('sort_order', 0),
        ];

        $translations = [];
        foreach (array_keys(config('app.locales', [])) as $locale) {
            $translations[] = [
                'locale' => $locale,
                'title' => (string) $this->request->input("title_{$locale}"),
                'subtitle' => (string) $this->request->input("subtitle_{$locale}"),
                'button_text' => (string) $this->request->input("button_text_{$locale}"),
            ];
        }

        $repo = new BannerRepository($this->db);
        try {
            $id = $repo->save($banner, $translations);
        } catch (PDOException $exception) {
            redirect_with_flash(admin_url('banners'), 'error', 'We could not save the hero banner. Please try again.');
        }
        (new ActivityLogService($this->db))->log($_SESSION['admin']['id'] ?? null, 'save', 'banners', $id, 'Saved banner #' . $id);
        redirect_with_flash(admin_url('banners'), 'success', 'Hero banner saved successfully.');
    }

    private function form(?int $id = null): void
    {
        $item = $id ? (new BannerRepository($this->db))->find($id) : null;
        if ($id !== null && !$item) {
            redirect_with_flash(admin_url('banners'), 'error', content_not_found_message());
        }

        $this->view('admin/banners/form', [
            'item' => $item,
            'metaTitle' => $id ? 'Edit Banner' : 'Create Banner',
        ], 'layouts/admin');
    }
}
