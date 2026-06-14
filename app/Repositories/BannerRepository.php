<?php

declare(strict_types=1);

namespace App\Repositories;

class BannerRepository extends BaseRepository
{
    public function active(): array
    {
        $locale = current_locale();
        $fallbackLocale = (string) config('app.locale', 'en');

        return $this->fetchAll(
            'SELECT b.*,
                    COALESCE(t_current.title, t_fallback.title) AS title,
                    COALESCE(t_current.subtitle, t_fallback.subtitle) AS subtitle,
                    COALESCE(t_current.button_text, t_fallback.button_text) AS button_text
             FROM banners b
             LEFT JOIN banner_translations t_current ON t_current.banner_id = b.id AND t_current.locale = :locale
             LEFT JOIN banner_translations t_fallback ON t_fallback.banner_id = b.id AND t_fallback.locale = :fallback_locale
             WHERE b.status = "published"
             ORDER BY b.sort_order ASC, b.id DESC',
            ['locale' => $locale, 'fallback_locale' => $fallbackLocale]
        );
    }

    public function allAdmin(): array
    {
        $locale = current_locale();
        $fallbackLocale = (string) config('app.locale', 'en');

        return $this->fetchAll(
            'SELECT b.*, COALESCE(t_current.title, t_fallback.title) AS title
             FROM banners b
             LEFT JOIN banner_translations t_current ON t_current.banner_id = b.id AND t_current.locale = :locale
             LEFT JOIN banner_translations t_fallback ON t_fallback.banner_id = b.id AND t_fallback.locale = :fallback_locale
             ORDER BY b.sort_order ASC, b.id DESC',
            ['locale' => $locale, 'fallback_locale' => $fallbackLocale]
        );
    }

    public function find(int $id): ?array
    {
        $banner = $this->fetchOne('SELECT * FROM banners WHERE id = :id', ['id' => $id]);
        if (!$banner) {
            return null;
        }

        $banner['translations'] = $this->fetchAll('SELECT * FROM banner_translations WHERE banner_id = :id', ['id' => $id]);
        return $banner;
    }

    public function save(array $banner, array $translations): int
    {
        if (!empty($banner['id'])) {
            $this->execute(
                'UPDATE banners SET image = :image, link = :link, status = :status, sort_order = :sort_order, updated_at = NOW() WHERE id = :id',
                $banner
            );
            $bannerId = (int) $banner['id'];
            $this->execute('DELETE FROM banner_translations WHERE banner_id = :banner_id', ['banner_id' => $bannerId]);
        } else {
            $this->execute(
                'INSERT INTO banners (image, link, status, sort_order, created_at, updated_at)
                 VALUES (:image, :link, :status, :sort_order, NOW(), NOW())',
                $banner
            );
            $bannerId = $this->lastInsertId();
        }

        foreach ($translations as $translation) {
            $translation['banner_id'] = $bannerId;
            $this->execute(
                'INSERT INTO banner_translations (banner_id, locale, title, subtitle, button_text)
                 VALUES (:banner_id, :locale, :title, :subtitle, :button_text)',
                $translation
            );
        }

        return $bannerId;
    }
}
