<?php

declare(strict_types=1);

namespace App\Http\Controllers\PublicSite;

use App\Core\Controller;
use App\Repositories\PageRepository;
use App\Repositories\PostRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\SettingRepository;

class ServiceController extends Controller
{
    public function index(): void
    {
        $repo = new ServiceRepository($this->db);
        $locale = current_locale();
        $settings = (new SettingRepository($this->db))->allGrouped()[$locale] ?? [];

        $this->view('public/services/index', [
            'services' => $repo->allPublished(),
            'settings' => $settings,
            'contactPage' => (new PageRepository($this->db))->findBySlug('contact'),
            'metaTitle' => site_meta_title($settings, $settings['nav_services_label'] ?? 'Our Services'),
            'metaDescription' => $settings['services_intro'] ?? '',
        ], 'layouts/public');
    }

    public function show(string $slug): void
    {
        $repo = new ServiceRepository($this->db);
        $service = $repo->findBySlug($slug);
        $locale = current_locale();
        $settings = (new SettingRepository($this->db))->allGrouped()[$locale] ?? [];

        if (!$service) {
            http_response_code(404);
            $this->view('public/not_found', [
                'title' => $settings['nav_services_label'] ?? 'Our Services',
                'message' => $settings['service_not_found_message'] ?? 'The requested service is not available.',
                'settings' => $settings,
                'metaTitle' => site_meta_title($settings, $settings['nav_services_label'] ?? 'Our Services'),
            ], 'layouts/public');
            return;
        }

        $active = resolved_translation($service, $locale);

        $this->view('public/services/show', [
            'service' => $service,
            'content' => $active,
            'settings' => $settings,
            'news' => array_slice((new PostRepository($this->db))->allByType('news', true), 0, 3),
            'contactPage' => (new PageRepository($this->db))->findBySlug('contact'),
            'metaTitle' => site_meta_title($settings, $active['seo_title'] ?: $active['title']),
            'metaDescription' => $active['seo_description'] ?? $active['summary'] ?? '',
            'metaKeywords' => $active['seo_keywords'] ?? '',
            'metaImage' => $service['cover_image'] ?? '',
        ], 'layouts/public');
    }
}
