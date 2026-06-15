<?php

declare(strict_types=1);

namespace App\Repositories;

class PostRepository extends BaseRepository
{
    public function allByType(string $type, bool $publishedOnly = false, array $filters = []): array
    {
        $where = 'WHERE p.type = :type';
        $params = ['type' => $type];
        if ($publishedOnly) {
            $where .= ' AND p.status = "published"';
        }

        $locale = current_locale();
        $fallbackLocale = (string) config('app.locale', 'en');
        $params['locale'] = $locale;
        $params['fallback_locale'] = $fallbackLocale;

        if (!empty($filters['status'])) {
            $where .= ' AND p.status = :status';
            $params['status'] = (string) $filters['status'];
        }

        if (!empty($filters['category_id'])) {
            $where .= ' AND p.category_id = :category_id';
            $params['category_id'] = (int) $filters['category_id'];
        }

        if (!empty($filters['q'])) {
            $where .= ' AND (p.slug LIKE :q OR t_current.title LIKE :q OR t_fallback.title LIKE :q OR t_current.excerpt LIKE :q OR t_fallback.excerpt LIKE :q)';
            $params['q'] = '%' . trim((string) $filters['q']) . '%';
        }

        return $this->fetchAll(
            "SELECT p.*,
                    c.name AS category_name,
                    COALESCE(t_current.title, t_fallback.title) AS title,
                    COALESCE(t_current.excerpt, t_fallback.excerpt) AS excerpt
             FROM posts p
             LEFT JOIN post_categories c ON c.id = p.category_id
             LEFT JOIN post_translations t_current ON t_current.post_id = p.id AND t_current.locale = :locale
             LEFT JOIN post_translations t_fallback ON t_fallback.post_id = p.id AND t_fallback.locale = :fallback_locale
             {$where}
             ORDER BY p.is_pinned DESC, p.published_at DESC, p.id DESC",
            $params
        );
    }

    public function categories(string $type): array
    {
        return $this->fetchAll('SELECT * FROM post_categories WHERE type = :type ORDER BY sort_order ASC, id DESC', ['type' => $type]);
    }

    public function find(int $id): ?array
    {
        $post = $this->fetchOne('SELECT * FROM posts WHERE id = :id', ['id' => $id]);
        if (!$post) {
            return null;
        }

        $post['translations'] = $this->fetchAll('SELECT * FROM post_translations WHERE post_id = :id', ['id' => $id]);
        return $post;
    }

    public function findBySlug(string $slug, string $type): ?array
    {
        $post = $this->fetchOne('SELECT * FROM posts WHERE slug = :slug AND type = :type AND status = "published"', ['slug' => $slug, 'type' => $type]);
        if (!$post) {
            return null;
        }

        $post['translations'] = $this->fetchAll('SELECT * FROM post_translations WHERE post_id = :id', ['id' => $post['id']]);
        return $post;
    }

    public function save(array $post, array $translations): int
    {
        $hasAttachmentDescription = $this->columnExists('posts', 'attachment_description');

        if (!empty($post['id'])) {
            if (!$hasAttachmentDescription) {
                unset($post['attachment_description']);
                $this->execute(
                    'UPDATE posts SET type = :type, category_id = :category_id, slug = :slug, cover_image = :cover_image, attachment_path = :attachment_path, attachment_name = :attachment_name, status = :status, is_pinned = :is_pinned, is_featured = :is_featured, sort_order = :sort_order, published_at = :published_at, updated_at = NOW() WHERE id = :id',
                    $post
                );
            } else {
                $this->execute(
                    'UPDATE posts SET type = :type, category_id = :category_id, slug = :slug, cover_image = :cover_image, attachment_path = :attachment_path, attachment_name = :attachment_name, attachment_description = :attachment_description, status = :status, is_pinned = :is_pinned, is_featured = :is_featured, sort_order = :sort_order, published_at = :published_at, updated_at = NOW() WHERE id = :id',
                    $post
                );
            }
            $postId = (int) $post['id'];
            $this->execute('DELETE FROM post_translations WHERE post_id = :post_id', ['post_id' => $postId]);
        } else {
            if (!$hasAttachmentDescription) {
                unset($post['attachment_description']);
                $this->execute(
                    'INSERT INTO posts (type, category_id, slug, cover_image, attachment_path, attachment_name, status, is_pinned, is_featured, sort_order, published_at, created_at, updated_at)
                     VALUES (:type, :category_id, :slug, :cover_image, :attachment_path, :attachment_name, :status, :is_pinned, :is_featured, :sort_order, :published_at, NOW(), NOW())',
                    $post
                );
            } else {
                $this->execute(
                    'INSERT INTO posts (type, category_id, slug, cover_image, attachment_path, attachment_name, attachment_description, status, is_pinned, is_featured, sort_order, published_at, created_at, updated_at)
                     VALUES (:type, :category_id, :slug, :cover_image, :attachment_path, :attachment_name, :attachment_description, :status, :is_pinned, :is_featured, :sort_order, :published_at, NOW(), NOW())',
                    $post
                );
            }
            $postId = $this->lastInsertId();
        }

        foreach ($translations as $translation) {
            $translation['post_id'] = $postId;
            $this->execute(
                'INSERT INTO post_translations (post_id, locale, title, excerpt, content, seo_title, seo_keywords, seo_description)
                 VALUES (:post_id, :locale, :title, :excerpt, :content, :seo_title, :seo_keywords, :seo_description)',
                $translation
            );
        }

        return $postId;
    }

    public function bulkStatus(string $type, array $ids, string $status): int
    {
        $ids = array_values(array_unique(array_filter(array_map('intval', $ids))));
        if ($ids === []) {
            return 0;
        }

        $allowed = array_keys(status_options());
        if (!in_array($status, $allowed, true)) {
            return 0;
        }

        $placeholders = [];
        $params = ['type' => $type, 'status' => $status];
        foreach ($ids as $index => $id) {
            $key = 'id_' . $index;
            $placeholders[] = ':' . $key;
            $params[$key] = $id;
        }

        $this->execute(
            'UPDATE posts SET status = :status, updated_at = NOW() WHERE type = :type AND id IN (' . implode(',', $placeholders) . ')',
            $params
        );

        return count($ids);
    }

    public function bulkDelete(string $type, array $ids): int
    {
        $ids = array_values(array_unique(array_filter(array_map('intval', $ids))));
        if ($ids === []) {
            return 0;
        }

        $placeholders = [];
        $params = ['type' => $type];
        foreach ($ids as $index => $id) {
            $key = 'id_' . $index;
            $placeholders[] = ':' . $key;
            $params[$key] = $id;
        }

        $idSql = implode(',', $placeholders);
        $this->execute(
            'DELETE FROM post_translations WHERE post_id IN (SELECT id FROM posts WHERE type = :type AND id IN (' . $idSql . '))',
            $params
        );
        $this->execute(
            'DELETE FROM posts WHERE type = :type AND id IN (' . $idSql . ')',
            $params
        );

        return count($ids);
    }
}
