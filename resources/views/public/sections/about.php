<?php $aboutContent = resolved_translation($aboutPage ?? null); ?>
<section class="home-about-section" id="about">
    <div class="container home-about-shell">
        <div class="home-about-copy">
            <h2><?= e(setting_value($settings, 'home_about_heading', 'Your Leading Air Cargo Sales & Service Provider')) ?></h2>
            <p><?= nl2br(e(setting_value($settings, 'home_about_body', strip_tags((string) ($aboutContent['content'] ?? ''))))) ?></p>
            <a class="hero-button mini" href="<?= e(app_url('about')) ?>"><?= e(setting_value($settings, 'home_about_button', 'LEARN MORE')) ?></a>
        </div>
        <div class="home-about-visual"<?= background_style($aboutPage['seo_image'] ?? '') ?>></div>
    </div>
</section>
