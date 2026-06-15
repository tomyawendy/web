<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Core\Controller;
use App\Repositories\PostRepository;
use App\Services\ActivityLogService;
use App\Services\UploadService;
use PDOException;

class PostController extends Controller
{
    public function index(): void
    {
        $type = normalize_post_type((string) $this->request->query('type', 'news'));
        $repo = new PostRepository($this->db);
        $filters = [
            'q' => trim((string) $this->request->query('q', '')),
            'status' => (string) $this->request->query('status', ''),
            'category_id' => (int) $this->request->query('category_id', 0),
        ];
        $this->view('admin/posts/index', [
            'type' => $type,
            'items' => $repo->allByType($type, false, $filters),
            'categories' => $repo->categories($type),
            'filters' => $filters,
            'metaTitle' => $type === 'news' ? 'Insights' : 'Documents',
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
        $type = normalize_post_type((string) $this->request->input('type', 'news'));
        if (!verify_csrf($this->request->input('_csrf'))) {
            redirect_with_flash(admin_url('posts?type=' . $type), 'error', session_expired_message());
        }

        $attachment = null;
        try {
            $attachment = (new UploadService())->store($this->request->file('attachment'), 'documents');
        } catch (\RuntimeException $exception) {
            redirect_with_flash(admin_url('posts?type=' . $type), 'error', $exception->getMessage());
        }

        $post = [
            'id' => $this->request->input('id') ?: null,
            'type' => $type,
            'category_id' => (int) $this->request->input('category_id', 0) ?: null,
            'slug' => trim((string) $this->request->input('slug')),
            'cover_image' => trim((string) $this->request->input('cover_image')),
            'attachment_path' => $attachment['file_path'] ?? (string) $this->request->input('existing_attachment_path'),
            'attachment_name' => $attachment['file_name'] ?? (string) $this->request->input('existing_attachment_name'),
            'attachment_description' => trim((string) $this->request->input('attachment_description', '')),
            'status' => (string) $this->request->input('status', 'draft'),
            'is_pinned' => $this->request->input('is_pinned') ? 1 : 0,
            'is_featured' => $this->request->input('is_featured') ? 1 : 0,
            'sort_order' => (int) $this->request->input('sort_order', 0),
            'published_at' => (string) $this->request->input('published_at') ?: date('Y-m-d H:i:s'),
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

        $repo = new PostRepository($this->db);
        try {
            $id = $repo->save($post, $translations);
        } catch (PDOException $exception) {
            $message = is_duplicate_key_error($exception)
                ? 'This content slug is already in use.'
                : 'We could not save the content item. Please try again.';
            redirect_with_flash(admin_url('posts?type=' . $post['type']), 'error', $message);
        }
        (new ActivityLogService($this->db))->log($_SESSION['admin']['id'] ?? null, 'save', 'posts', $id, 'Saved ' . $post['type'] . ' ' . $post['slug']);
        redirect_with_flash(admin_url('posts?type=' . $post['type']), 'success', $post['type'] === 'news' ? 'Insight saved successfully.' : 'Document saved successfully.');
    }

    public function bulk(): void
    {
        $type = normalize_post_type((string) $this->request->input('type', 'news'));
        if (!verify_csrf($this->request->input('_csrf'))) {
            redirect_with_flash(admin_url('posts?type=' . $type), 'error', session_expired_message());
        }

        $ids = $_POST['ids'] ?? [];
        $ids = is_array($ids) ? $ids : [];
        $bulkAction = (string) $this->request->input('bulk_action', 'status');
        $repo = new PostRepository($this->db);

        if ($bulkAction === 'delete') {
            $count = $repo->bulkDelete($type, $ids);
            if ($count === 0) {
                redirect_with_flash(admin_url('posts?type=' . $type), 'error', 'Select at least one item to delete.');
            }

            (new ActivityLogService($this->db))->log($_SESSION['admin']['id'] ?? null, 'bulk_delete', 'posts', null, 'Deleted ' . $count . ' ' . $type . ' item(s)');
            redirect_with_flash(admin_url('posts?type=' . $type), 'success', 'Selected items deleted successfully.');
        }

        $status = (string) $this->request->input('bulk_status', '');
        $count = $repo->bulkStatus($type, $ids, $status);

        if ($count === 0) {
            redirect_with_flash(admin_url('posts?type=' . $type), 'error', 'Select at least one item and a valid status.');
        }

        (new ActivityLogService($this->db))->log($_SESSION['admin']['id'] ?? null, 'bulk_status', 'posts', null, 'Changed ' . $count . ' ' . $type . ' item(s) to ' . $status);
        redirect_with_flash(admin_url('posts?type=' . $type), 'success', 'Bulk status updated successfully.');
    }

    private function form(?int $id = null): void
    {
        $repo = new PostRepository($this->db);
        $item = $id ? $repo->find($id) : null;
        $requestedType = normalize_post_type((string) $this->request->query('type', 'news'));
        if ($id !== null && !$item) {
            redirect_with_flash(admin_url('posts?type=' . $requestedType), 'error', content_not_found_message());
        }

        $type = $item['type'] ?? $requestedType;

        $this->view('admin/posts/form', [
            'item' => $item,
            'type' => $type,
            'categories' => $repo->categories($type),
            'metaTitle' => $id ? ($type === 'news' ? 'Edit Insight' : 'Edit Document') : ($type === 'news' ? 'Create Insight' : 'Create Document'),
        ], 'layouts/admin');
    }
}
