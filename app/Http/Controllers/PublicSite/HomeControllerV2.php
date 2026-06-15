<?php

declare(strict_types=1);

namespace App\Http\Controllers\PublicSite;

use App\Core\Controller;
use App\Repositories\BannerRepository;
use App\Repositories\PageRepository;
use App\Repositories\PostRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\SettingRepository;

class HomeControllerV2 extends Controller
{
    public function index(): void
    {
        $bannerRepo = new BannerRepository($this->db);
        $serviceRepo = new ServiceRepository($this->db);
        $postRepo = new PostRepository($this->db);
        $settingsRepo = new SettingRepository($this->db);
        $pageRepo = new PageRepository($this->db);

        $settings = $settingsRepo->allGrouped();
        $locale = current_locale();
        $activeSettings = $settings[$locale] ?? [];

        $this->view('public/home_v2', [
            'settings' => $activeSettings,
            'heroBanner' => $bannerRepo->active()[0] ?? null,
            'aboutPage' => $pageRepo->findBySlug('about'),
            'contactPage' => $pageRepo->findBySlug('contact'),
            'services' => $serviceRepo->allPublished(),
            'news' => array_slice($postRepo->allByType('news', true), 0, 3),
            'metaTitle' => site_meta_title($activeSettings, $activeSettings['homepage_meta_title'] ?? ($activeSettings['homepage_title'] ?? 'Premium Choice For Air Logistics Solution!')),
            'metaDescription' => $activeSettings['homepage_meta_description'] ?? ($activeSettings['homepage_subtitle'] ?? ''),
            'metaKeywords' => $activeSettings['homepage_meta_keywords'] ?? '',
            'metaImage' => $activeSettings['homepage_og_image'] ?? '',
        ], 'layouts/public');
    }
}
