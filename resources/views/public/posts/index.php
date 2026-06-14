<section class="news-section listing-page <?= $type === 'news' ? 'insights-entry-stage' : 'documents-entry-stage' ?>">
    <div class="container">
        <?php if ($type === 'news'): ?>
            <?php
            $headingKicker = setting_value($settings ?? [], 'news_kicker_label', 'Insights');
            $headingTitle = setting_value($settings ?? [], 'news_heading', 'Latest News');
            $headingActionText = setting_value($settings ?? [], 'news_view_all_label', 'VIEW ALL ARTICLES');
            $headingActionHref = app_url('insights');
            include base_path('resources/views/public/components/section_heading.php');
            ?>
        <?php else: ?>
            <div class="service-head listing-page-head">
                <div>
                    <span class="tiny-link"><?= e(setting_value($settings ?? [], 'nav_documents_label', 'Documents')) ?></span>
                    <h2><?= e($title) ?></h2>
                    <p><?= e('Official documents, operational notices, and downloadable files for quick reference.') ?></p>
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
                <h3><?= e($type === 'news' ? 'No insights published yet.' : 'No documents available yet.') ?></h3>
                <p><?= e($type === 'news' ? 'Once content is published in the CMS, it will appear here automatically.' : 'Upload and publish documents in the backend, then they will appear here automatically.') ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php $homeContactStage = true; ?>
<?php include base_path('resources/views/public/partials/contact_block.php'); ?>
<?php $homeNewsletterStage = true; ?>
<?php include base_path('resources/views/public/partials/newsletter.php'); ?>
