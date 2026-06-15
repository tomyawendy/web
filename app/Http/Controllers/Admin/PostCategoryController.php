<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Core\Controller;
use App\Repositories\PostCategoryRepository;
use App\Services\ActivityLogService;

class PostCategoryController extends Controller
{
    public function index(): void
    {
        $type = normalize_post_type((string) $this->request->query('type', 'news'));
        $repo = new PostCategoryRepository($this->db);
        $this->view('admin/post_categories/index', [
            'type' => $type,
            'items' => $repo->all($type),
            'metaTitle' => 'Content Categories',
        ], 'layouts/admin');
    }

    public function edit(string $id): void
    {
        $repo = new PostCategoryRepository($this->db);
        $item = $repo->find((int) $id);
        if (!$item) {
            redirect_with_flash(admin_url('post-categories'), 'error', content_not_found_message());
        }

        $this->view('admin/post_categories/index', [
            'type' => normalize_post_type((string) ($item['type'] ?? 'news')),
            'item' => $item,
            'items' => $repo->all((string) $item['type']),
            'metaTitle' => 'Edit Content Category',
        ], 'layouts/admin');
    }

    public function save(): void
    {
        $type = normalize_post_type((string) $this->request->input('type', 'news'));
        if (!verify_csrf($this->request->input('_csrf'))) {
            redirect_with_flash(admin_url('post-categories?type=' . $type), 'error', session_expired_message());
        }

        $name = trim((string) $this->request->input('name'));
        if ($name === '') {
            redirect_with_flash(admin_url('post-categories?type=' . $type), 'error', 'Please enter a category name.');
        }

        $id = (new PostCategoryRepository($this->db))->save([
            'id' => (int) $this->request->input('id', 0) ?: null,
            'type' => $type,
            'name' => $name,
            'sort_order' => (int) $this->request->input('sort_order', 0),
        ]);

        (new ActivityLogService($this->db))->log($_SESSION['admin']['id'] ?? null, 'save', 'post_categories', $id, 'Saved ' . $type . ' category ' . $name);
        redirect_with_flash(admin_url('post-categories?type=' . $type), 'success', 'Category saved successfully.');
    }
}
