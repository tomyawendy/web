<?php

declare(strict_types=1);

namespace App\Http\Controllers\PublicSite;

use App\Core\Controller;
use App\Repositories\PageRepository;
use App\Repositories\PostRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\SettingRepository;

class PageController extends Controller
{
    public function about(): void
    {
        $this->show('about');
    }

    public function contact(): void
    {
        $this->show('contact');
    }

    public function show(string $slug): void
    {
        $pageRepo = new PageRepository($this->db);
        $settingsRepo = new SettingRepository($this->db);
        $page = $pageRepo->findBySlug($slug);
        $locale = current_locale();
        $settings = $settingsRepo->allGrouped()[$locale] ?? [];

        if (!$page) {
            http_response_code(404);
            $this->view('public/not_found', [
                'title' => $settings['site_name'] ?? 'Planet Aviation',
                'message' => $settings['page_not_found_message'] ?? 'The requested page is not available.',
                'settings' => $settings,
                'metaTitle' => site_meta_title($settings),
            ], 'layouts/public');
            return;
        }

        $active = resolved_translation($page, $locale);

        $this->view('public/page', [
            'page' => $page,
            'content' => $active,
            'settings' => $settings,
            'contactPage' => $pageRepo->findBySlug('contact'),
            'services' => (new ServiceRepository($this->db))->allPublished(),
            'news' => array_slice((new PostRepository($this->db))->allByType('news', true), 0, 3),
            'metaTitle' => site_meta_title($settings, $active['seo_title'] ?: $active['title']),
        ], 'layouts/public');
    }
}
