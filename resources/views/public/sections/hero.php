<?php
$heroButtonText = $heroBanner['button_text'] ?? setting_value($settings, 'hero_button_text', 'LEARN MORE');
$heroTitle = $heroBanner['title'] ?? setting_value($settings, 'homepage_title', "Premium Choice\nFor Air Logistics Solution!");
$heroSubtitle = $heroBanner['subtitle'] ?? setting_value($settings, 'homepage_subtitle', '');
if (strpos($heroTitle, "\n") === false && preg_match('/^Premium Choice for Air Logistics Solution!?$/i', trim($heroTitle))) {
    $heroTitle = "Premium Choice\nFor Air Logistics Solution!";
}
?>
<section class="hero-panel-home">
    <div class="container hero-home-shell">
        <div class="hero-home-card">
            <p class="hero-kicker"><?= e(setting_value($settings, 'hero_kicker', 'PLANET AVIATION, S.L.,')) ?></p>
            <h1><?= nl2br(e($heroTitle)) ?></h1>
            <?php if ($heroSubtitle !== ''): ?>
                <p class="hero-subtitle"><?= e($heroSubtitle) ?></p>
            <?php endif; ?>
            <a class="hero-button" href="<?= e(app_url() . '#about') ?>"><?= e($heroButtonText) ?></a>
        </div>
        <div class="hero-home-image">
            <?php if (($heroBanner['image'] ?? '') !== ''): ?>
                <img class="hero-home-art" src="<?= e(media_url($heroBanner['image'])) ?>" alt="" aria-hidden="true">
            <?php endif; ?>
        </div>
    </div>
</section>
