<section class="service-detail-page">
    <div class="container service-detail-shell">
        <div class="service-detail-copy">
            <h1><?= e($content['title']) ?></h1>
            <p class="service-detail-summary"><?= e($content['summary']) ?></p>
            <div class="prose">
                <?= $content['content'] ?>
            </div>
        </div>
        <div class="service-detail-visual"<?= background_style($service['cover_image'] ?? '') ?>></div>
    </div>
</section>
<?php include base_path('resources/views/public/partials/contact_block.php'); ?>
<?php include base_path('resources/views/public/partials/newsletter.php'); ?>
