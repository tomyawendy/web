<section class="post-detail-page <?= $post['type'] === 'news' ? 'insight-detail-page' : 'document-detail-page' ?>">
    <div class="container post-detail-shell">
        <div class="post-detail-copy">
            <span class="tiny-link"><?= e($post['type'] === 'news' ? setting_value($settings ?? [], 'news_kicker_label', 'INSIGHT') : setting_value($settings ?? [], 'nav_documents_label', 'Documents')) ?></span>
            <h1><?= e($content['title']) ?></h1>
            <p class="post-detail-summary"><?= e($content['excerpt']) ?></p>
            <span class="meta-line"><?= e(format_datetime($post['published_at'])) ?></span>
            <div class="prose">
                <?= $content['content'] ?>
                <?php if (!empty($post['attachment_path'])): ?>
                    <?php if (!empty($post['attachment_description'])): ?>
                        <p><?= e((string) $post['attachment_description']) ?></p>
                    <?php endif; ?>
                    <p><a class="quote-button" href="<?= e(media_url($post['attachment_path'])) ?>" target="_blank"><?= e(setting_value($settings ?? [], 'download_attachment_label', 'DOWNLOAD ATTACHMENT')) ?></a></p>
                <?php endif; ?>
            </div>
            <a class="post-back-link" href="<?= e(app_url($post['type'] === 'news' ? 'insights' : 'documents')) ?>"><?= e($post['type'] === 'news' ? 'BACK TO INSIGHTS' : 'BACK TO DOCUMENTS') ?></a>
        </div>
        <div class="post-detail-visual"<?= background_style($post['cover_image'] ?? '') ?>></div>
    </div>
</section>
<?php $homeContactStage = true; ?>
<?php include base_path('resources/views/public/partials/contact_block.php'); ?>
<?php $homeNewsletterStage = true; ?>
<?php include base_path('resources/views/public/partials/newsletter.php'); ?>
