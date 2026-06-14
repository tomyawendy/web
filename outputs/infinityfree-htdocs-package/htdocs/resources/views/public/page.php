<?php if ($page['slug'] === 'about'): ?>
<section class="about-page-stage">
    <div class="container home-about-shell">
        <div class="home-about-copy">
            <h2><?= e(setting_value($settings, 'home_about_heading', $content['title'])) ?></h2>
            <p><?= nl2br(e(strip_tags($content['content']))) ?></p>
        </div>
    </div>
</section>
    <?php $homeContactStage = true; ?>
    <?php include base_path('resources/views/public/partials/contact_block.php'); ?>
    <?php $homeNewsletterStage = true; ?>
    <?php include base_path('resources/views/public/partials/newsletter.php'); ?>
<?php elseif ($page['slug'] === 'contact'): ?>
    <?php $homeContactStage = true; ?>
    <?php include base_path('resources/views/public/partials/contact_block.php'); ?>
    <?php $homeNewsletterStage = true; ?>
    <?php include base_path('resources/views/public/partials/newsletter.php'); ?>
<?php else: ?>
<section class="generic-page">
    <div class="container prose">
        <h1><?= e($content['title']) ?></h1>
        <?= $content['content'] ?>
    </div>
</section>
<?php endif; ?>
