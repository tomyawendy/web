<section class="news-section listing-page <?= $type === 'news' ? 'insights-entry-stage insights-figma-stage' : 'documents-entry-stage' ?>">
    <?php if ($type === 'news'): ?>
        <?php if ($posts): ?>
            <nav class="insights-stage-hotspots" aria-label="Insights quick links">
                <a class="insights-hotspot-all" href="<?= e(app_url('insights')) ?>"><?= e(setting_value($settings ?? [], 'news_view_all_label', 'VIEW ALL ARTICLES')) ?></a>
                <?php foreach (array_slice($posts, 0, 3) as $index => $item): ?>
                    <a class="insights-hotspot-card insights-hotspot-card-<?= e((string) ($index + 1)) ?>" href="<?= e(app_url('insights/' . $item['slug'])) ?>"><?= e($item['title']) ?></a>
                <?php endforeach; ?>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
    <div class="container">
        <?php if ($type !== 'news'): ?>
            <div class="service-head listing-page-head">
                <div>
                    <span class="tiny-link"><?= e(setting_value($settings ?? [], 'nav_documents_label', 'Documents')) ?></span>
                    <h2><?= e($title) ?></h2>
                    <p><?= e(setting_value($settings ?? [], 'documents_intro', 'Official documents, operational notices, and downloadable files for quick reference.')) ?></p>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($posts): ?>
            <div class="news-grid">
                <?php foreach ($posts as $item): ?>
                    <article class="news-card">
                        <a class="news-card-link" href="<?= e(app_url(($type === 'news' ? 'insights/' : 'documents/') . $item['slug'])) ?>">
                            <div class="news-thumb"<?= background_style($item['cover_image'] ?? '') ?>></div>
                            <span><?= e(format_datetime($item['published_at'])) ?></span>
                            <h3><?= e($item['title']) ?></h3>
                            <p><?= e($item['excerpt']) ?></p>
                        </a>
                        <a class="news-link" href="<?= e(app_url(($type === 'news' ? 'insights/' : 'documents/') . $item['slug'])) ?>"><?= e(setting_value($settings, 'read_more_label', 'READ MORE')) ?></a>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="listing-empty">
                <h3><?= e($type === 'news' ? setting_value($settings ?? [], 'empty_insights_title', 'No insights published yet.') : setting_value($settings ?? [], 'empty_documents_title', 'No documents available yet.')) ?></h3>
                <p><?= e($type === 'news' ? setting_value($settings ?? [], 'empty_insights_body', 'Once content is published in the CMS, it will appear here automatically.') : setting_value($settings ?? [], 'empty_documents_body', 'Upload and publish documents in the backend, then they will appear here automatically.')) ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php $homeContactStage = true; ?>
<?php include base_path('resources/views/public/partials/contact_block.php'); ?>
<?php $homeNewsletterStage = true; ?>
<?php include base_path('resources/views/public/partials/newsletter.php'); ?>
