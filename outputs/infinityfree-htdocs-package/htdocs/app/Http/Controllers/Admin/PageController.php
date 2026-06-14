<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Core\Controller;
use App\Repositories\PageRepository;
use App\Services\ActivityLogService;
use PDOException;

class PageController extends Controller
{
    public function index(): void
    {
        $this->view('admin/pages/index', [
            'items' => (new PageRepository($this->db))->all(),
            'metaTitle' => 'Content Pages',
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
        $this->saveRecord(new PageRepository($this->db), 'pages');
    }

    private function form(?int $id = null): void
    {
        $page = $id ? (new PageRepository($this->db))->find($id) : null;
        if ($id !== null && !$page) {
            redirect_with_flash(admin_url('pages'), 'error', content_not_found_message());
        }

        $this->view('admin/pages/form', [
            'item' => $page,
            'metaTitle' => $id ? 'Edit Content Page' : 'Create Content Page',
        ], 'layouts/admin');
    }

    private function saveRecord(PageRepository $repo, string $module): void
    {
        if (!verify_csrf($this->request->input('_csrf'))) {
            redirect_with_flash(admin_url($module), 'error', session_expired_message());
        }

        $page = [
            'id' => $this->request->input('id') ?: null,
            'slug' => trim((string) $this->request->input('slug')),
            'template' => trim((string) $this->request->input('template')) ?: 'default',
            'status' => (string) $this->request->input('status', 'draft'),
            'sort_order' => (int) $this->request->input('sort_order', 0),
            'seo_image' => trim((string) $this->request->input('seo_image')),
        ];

        $translations = [];
        foreach (array_keys(config('app.locales', [])) as $locale) {
            $translations[] = [
                'locale' => $locale,
                'title' => (string) $this->request->input("title_{$locale}"),
                'excerpt' => (string) $this->request->input("excerpt_{$locale}"),
                'content' => (string) $this->request->input("content_{$locale}"),
                'seo_title' => (string) $this->request->input("seo_title_{$locale}"),
                'seo_keywords' => (string) $this->request->input("seo_keywords_{$locale}"),
                'seo_description' => (string) $this->request->input("seo_description_{$locale}"),
            ];
        }

        try {
            $id = $repo->save($page, $translations);
        } catch (PDOException $exception) {
            $message = is_duplicate_key_error($exception)
                ? 'This page slug is already in use.'
                : 'We could not save the content page. Please try again.';
            redirect_with_flash(admin_url('pages'), 'error', $message);
        }
        $user = $_SESSION['admin'] ?? null;
        (new ActivityLogService($this->db))->log($user['id'] ?? null, 'save', 'pages', $id, 'Saved page ' . $page['slug']);
        redirect_with_flash(admin_url('pages'), 'success', 'Content page saved successfully.');
    }
}
