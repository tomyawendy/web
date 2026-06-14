<?php

declare(strict_types=1);

namespace App\Repositories;

class ServiceRepository extends BaseRepository
{
    public function allPublished(): array
    {
        $locale = current_locale();
        $fallbackLocale = (string) config('app.locale', 'en');

        return $this->fetchAll(
            'SELECT s.*,
                    COALESCE(t_current.title, t_fallback.title) AS title,
                    COALESCE(t_current.summary, t_fallback.summary) AS summary,
                    COALESCE(t_current.content, t_fallback.content) AS content
             FROM services s
             LEFT JOIN service_translations t_current ON t_current.service_id = s.id AND t_current.locale = :locale
             LEFT JOIN service_translations t_fallback ON t_fallback.service_id = s.id AND t_fallback.locale = :fallback_locale
             WHERE s.status = "published"
             ORDER BY s.sort_order ASC, s.id DESC',
            ['locale' => $locale, 'fallback_locale' => $fallbackLocale]
        );
    }

    public function allAdmin(): array
    {
        $locale = current_locale();
        $fallbackLocale = (string) config('app.locale', 'en');

        return $this->fetchAll(
            'SELECT s.*, COALESCE(t_current.title, t_fallback.title) AS title
             FROM services s
             LEFT JOIN service_translations t_current ON t_current.service_id = s.id AND t_current.locale = :locale
             LEFT JOIN service_translations t_fallback ON t_fallback.service_id = s.id AND t_fallback.locale = :fallback_locale
             ORDER BY s.sort_order ASC, s.id DESC',
            ['locale' => $locale, 'fallback_locale' => $fallbackLocale]
        );
    }

    public function find(int $id): ?array
    {
        $service = $this->fetchOne('SELECT * FROM services WHERE id = :id', ['id' => $id]);
        if (!$service) {
            return null;
        }

        $service['translations'] = $this->fetchAll('SELECT * FROM service_translations WHERE service_id = :id', ['id' => $id]);
        return $service;
    }

    public function findBySlug(string $slug): ?array
    {
        $service = $this->fetchOne('SELECT * FROM services WHERE slug = :slug AND status = "published"', ['slug' => $slug]);
        if (!$service) {
            return null;
        }

        $service['translations'] = $this->fetchAll('SELECT * FROM service_translations WHERE service_id = :id', ['id' => $service['id']]);
        return $service;
    }

    public function save(array $service, array $translations): int
    {
        if (!empty($service['id'])) {
            $this->execute(
                'UPDATE services SET slug = :slug, icon = :icon, cover_image = :cover_image, status = :status, sort_order = :sort_order, updated_at = NOW() WHERE id = :id',
                $service
            );
            $serviceId = (int) $service['id'];
            $this->execute('DELETE FROM service_translations WHERE service_id = :service_id', ['service_id' => $serviceId]);
        } else {
            $this->execute(
                'INSERT INTO services (slug, icon, cover_image, status, sort_order, created_at, updated_at)
                 VALUES (:slug, :icon, :cover_image, :status, :sort_order, NOW(), NOW())',
                $service
            );
            $serviceId = $this->lastInsertId();
        }

        foreach ($translations as $translation) {
            $translation['service_id'] = $serviceId;
            $this->execute(
                'INSERT INTO service_translations (service_id, locale, title, summary, content, seo_title, seo_keywords, seo_description)
                 VALUES (:service_id, :locale, :title, :summary, :content, :seo_title, :seo_keywords, :seo_description)',
                $translation
            );
        }

        return $serviceId;
    }
}
