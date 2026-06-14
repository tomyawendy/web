<?php

declare(strict_types=1);

namespace App\Repositories;

class PageRepository extends BaseRepository
{
    public function all(): array
    {
        $locale = current_locale();
        $fallbackLocale = (string) config('app.locale', 'en');

        return $this->fetchAll(
            'SELECT p.*, COALESCE(t_current.title, t_fallback.title) AS title, :locale AS locale
             FROM pages p
             LEFT JOIN page_translations t_current ON t_current.page_id = p.id AND t_current.locale = :locale
             LEFT JOIN page_translations t_fallback ON t_fallback.page_id = p.id AND t_fallback.locale = :fallback_locale
             ORDER BY p.sort_order ASC, p.id DESC',
            ['locale' => $locale, 'fallback_locale' => $fallbackLocale]
        );
    }

    public function find(int $id): ?array
    {
        $page = $this->fetchOne('SELECT * FROM pages WHERE id = :id', ['id' => $id]);
        if (!$page) {
            return null;
        }

        $page['translations'] = $this->fetchAll(
            'SELECT * FROM page_translations WHERE page_id = :page_id',
            ['page_id' => $id]
        );

        return $page;
    }

    public function findBySlug(string $slug): ?array
    {
        $page = $this->fetchOne('SELECT * FROM pages WHERE slug = :slug AND status = "published"', ['slug' => $slug]);
        if (!$page) {
            return null;
        }

        $page['translations'] = $this->fetchAll('SELECT * FROM page_translations WHERE page_id = :page_id', ['page_id' => $page['id']]);
        return $page;
    }

    public function save(array $page, array $translations): int
    {
        if (!empty($page['id'])) {
            $this->execute(
                'UPDATE pages SET slug = :slug, template = :template, status = :status, sort_order = :sort_order, seo_image = :seo_image, updated_at = NOW() WHERE id = :id',
                $page
            );
            $pageId = (int) $page['id'];
            $this->execute('DELETE FROM page_translations WHERE page_id = :page_id', ['page_id' => $pageId]);
        } else {
            $this->execute(
                'INSERT INTO pages (slug, template, status, sort_order, seo_image, created_at, updated_at)
                 VALUES (:slug, :template, :status, :sort_order, :seo_image, NOW(), NOW())',
                $page
            );
            $pageId = $this->lastInsertId();
        }

        foreach ($translations as $translation) {
            $translation['page_id'] = $pageId;
            $this->execute(
                'INSERT INTO page_translations (page_id, locale, title, excerpt, content, seo_title, seo_keywords, seo_description)
                 VALUES (:page_id, :locale, :title, :excerpt, :content, :seo_title, :seo_keywords, :seo_description)',
                $translation
            );
        }

        return $pageId;
    }
}
