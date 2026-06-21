<?php

declare(strict_types=1);

namespace App\Http\Controllers\PublicSite;

use App\Core\Controller;
use App\Repositories\PageRepository;
use App\Repositories\PostRepository;
use App\Repositories\SettingRepository;

class PostController extends Controller
{
    public function newsIndex(): void
    {
        $this->listing('news', 'Insights');
    }

    public function documentIndex(): void
    {
        $this->listing('document', 'Documents');
    }

    public function showNews(string $slug): void
    {
        $this->detail($slug, 'news');
    }

    public function showDocument(string $slug): void
    {
        $this->detail($slug, 'document');
    }

    private function listing(string $type, string $title): void
    {
        $repo = new PostRepository($this->db);
        $locale = current_locale();
        $settings = public_settings_for_display((new SettingRepository($this->db))->allGrouped()[$locale] ?? [], $locale);
        $resolvedTitle = $type === 'news'
            ? ($settings['nav_insights_label'] ?? $title)
            : ($settings['nav_documents_label'] ?? $title);

        $this->view('public/posts/index', [
            'type' => $type,
            'title' => $resolvedTitle,
            'posts' => public_posts_for_display($repo->allByType($type, true), $locale),
            'categories' => $repo->categories($type),
            'settings' => $settings,
            'contactPage' => (new PageRepository($this->db))->findBySlug('contact'),
            'metaTitle' => site_meta_title($settings, $resolvedTitle),
            'metaDescription' => $settings['post_not_found_message'] ?? '',
        ], 'layouts/public');
    }

    private function detail(string $slug, string $type): void
    {
        $repo = new PostRepository($this->db);
        $post = $repo->findBySlug($slug, $type);
        $locale = current_locale();
        $settings = public_settings_for_display((new SettingRepository($this->db))->allGrouped()[$locale] ?? [], $locale);

        if (!$post) {
            http_response_code(404);
            $title = $type === 'news'
                ? ($settings['nav_insights_label'] ?? 'Insights')
                : ($settings['nav_documents_label'] ?? 'Documents');

            $this->view('public/not_found', [
                'title' => $title,
                'message' => $settings['post_not_found_message'] ?? 'The requested content is not available.',
                'settings' => $settings,
                'metaTitle' => site_meta_title($settings, $title),
            ], 'layouts/public');
            return;
        }

        $post = public_post_for_display($post, $locale);
        $active = public_post_for_display(array_merge(resolved_translation($post, $locale), ['slug' => $post['slug']]), $locale);

        $this->view('public/posts/show', [
            'post' => $post,
            'content' => $active,
            'settings' => $settings,
            'contactPage' => (new \App\Repositories\PageRepository($this->db))->findBySlug('contact'),
            'metaTitle' => site_meta_title($settings, $active['seo_title'] ?: $active['title']),
            'metaDescription' => $active['seo_description'] ?? $active['excerpt'] ?? '',
            'metaKeywords' => $active['seo_keywords'] ?? '',
            'metaImage' => $post['cover_image'] ?? '',
        ], 'layouts/public');
    }
}
