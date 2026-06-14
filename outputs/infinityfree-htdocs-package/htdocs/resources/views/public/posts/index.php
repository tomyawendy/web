<section class="news-section listing-page <?= $type === 'news' ? 'insights-entry-stage' : 'documents-entry-stage' ?>">
    <div class="container">
        <div class="service-head listing-page-head">
            <div>
                <span class="tiny-link"><?= e($type === 'news' ? setting_value($settings ?? [], 'news_kicker_label', 'INSIGHT') : setting_value($settings ?? [], 'nav_documents_label', 'Documents')) ?></span>
                <h2><?= e($title) ?></h2>
                <p><?= e($type === 'news' ? 'Latest aviation market updates, operational notices, and logistics insights from Planet Aviation.' : 'Official documents, operational notices, and downloadable files for quick reference.') ?></p>
            </div>
        </div>
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
