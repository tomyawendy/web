<section class="service-overview services-entry-stage">
    <div class="container">
        <div class="service-head services-page-head home-services-head">
            <div>
                <span class="tiny-link"><?= e(setting_value($settings, 'services_kicker_label', 'View all')) ?></span>
                <a class="services-filter-link" href="<?= e(app_url('services')) ?>"><?= e(setting_value($settings, 'services_filter_label', 'Products & Services')) ?></a>
                <h2><?= e(setting_value($settings, 'services_heading', 'Delivering Service Excellence')) ?></h2>
            </div>
            <p><?= e(setting_value($settings, 'services_intro', 'Planet Aviation offers a comprehensive portfolio of air cargo products and services.')) ?></p>
        </div>
    </div>
    <?php if ($services): ?>
        <nav class="service-hotspots" aria-label="Service quick links">
            <a class="service-hotspot-all" href="<?= e(app_url('services')) ?>"><?= e(setting_value($settings, 'services_kicker_label', 'View all')) ?></a>
            <a class="service-hotspot-filter" href="<?= e(app_url('services')) ?>"><?= e(setting_value($settings, 'services_filter_label', 'Products & Services')) ?></a>
            <?php foreach (array_slice($services, 0, 4) as $index => $service): ?>
                <a class="service-hotspot-<?= e((string) ($index + 1)) ?>" href="<?= e(app_url('services/' . $service['slug'])) ?>"><?= e($service['title']) ?></a>
            <?php endforeach; ?>
        </nav>
    <?php endif; ?>
</section>
<?php $homeContactStage = true; ?>
<?php include base_path('resources/views/public/partials/contact_block.php'); ?>
<?php $homeNewsletterStage = true; ?>
<?php include base_path('resources/views/public/partials/newsletter.php'); ?>
