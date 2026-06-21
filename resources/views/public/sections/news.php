<section class="news-section" id="insights">
    <div class="container">
        <?php
        $headingKicker = setting_value($settings, 'news_kicker_label', 'INSIGHT');
        $headingTitle = setting_value($settings, 'news_heading', 'Latest News');
        $headingActionText = setting_value($settings, 'news_view_all_label', 'VIEW ALL ARTICLES');
        $headingActionHref = localized_url('insights');
        include base_path('resources/views/public/components/section_heading.php');
        ?>
        <div class="news-grid">
            <?php foreach ($news as $item): ?>
                <article class="news-card" id="news-<?= e($item['slug']) ?>">
                    <div class="news-thumb"<?= background_style($item['cover_image'] ?? '') ?>></div>
                    <span><?= e(format_datetime($item['published_at'])) ?></span>
                    <h3><?= e($item['title']) ?></h3>
                    <p><?= e($item['excerpt']) ?></p>
                    <a class="news-link" href="<?= e(localized_url('insights/' . $item['slug'])) ?>"><?= e(setting_value($settings, 'read_more_label', 'READ MORE')) ?></a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
