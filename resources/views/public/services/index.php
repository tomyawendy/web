<section class="service-overview services-entry-stage">
    <div class="container">
        <div class="service-head services-page-head home-services-head">
            <div>
                <span class="tiny-link"><?= e(setting_value($settings, 'services_kicker_label', 'View all')) ?></span>
                <a class="services-filter-link" href="<?= e(localized_url('services')) ?>"><?= e(setting_value($settings, 'services_filter_label', 'Products & Services')) ?></a>
                <h2><?= e(setting_value($settings, 'services_heading', 'Delivering Service Excellence')) ?></h2>
            </div>
            <p><?= e(setting_value($settings, 'services_intro', 'Planet Aviation offers a comprehensive portfolio of air cargo products and services.')) ?></p>
        </div>
        <?php if ($services): ?>
            <div class="home-services-list services-entry-list">
                <?php foreach (array_slice($services, 0, 4) as $index => $service): ?>
                    <?php $serviceItems = array_slice(content_list_items($service['content'] ?? ''), 0, 4); ?>
                    <?php $serviceVisual = $service['cover_image'] ?? ''; ?>
                    <?php $figmaServiceVisual = 'figma/service-' . ($index + 1) . '-crop.png'; ?>
                    <?php $usesLegacyFigmaSeed = preg_match('#^assets/figma/service_[24]\.png$#', $serviceVisual) === 1; ?>
                    <?php $serviceVisualStyle = ($serviceVisual !== '' && !$usesLegacyFigmaSeed) ? background_style($serviceVisual) : ' style="background-image:url(' . e(asset_url($figmaServiceVisual)) . ')"'; ?>
                    <article class="home-service-row" id="service-<?= e($service['slug']) ?>">
                        <div class="home-service-copy">
                            <span class="home-service-index"><?= e(sprintf('%02d', $index + 1)) ?></span>
                            <?php $serviceTitle = ($index === 3 && current_locale() !== 'es') ? setting_value($settings, 'services_fourth_home_title', $service['title']) : $service['title']; ?>
                            <h3><?= e($serviceTitle) ?></h3>
                            <p class="home-service-lead"><?= e($service['summary']) ?></p>
                            <?php if ($serviceItems): ?>
                                <strong class="home-service-label"><?= e(setting_value($settings, 'services_impact_label', 'Our Impact')) ?></strong>
                                <ul class="home-service-bullets">
                                    <?php foreach ($serviceItems as $item): ?>
                                        <li><?= e($item) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            <a class="hero-button mini" href="<?= e(localized_url('services/' . $service['slug'])) ?>"><?= e(setting_value($settings, 'services_learn_more_label', 'LEARN MORE')) ?></a>
                        </div>
                        <div class="home-service-visual"<?= $serviceVisualStyle ?>></div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php if ($services): ?>
        <nav class="service-hotspots" aria-label="<?= e(current_locale() === 'es' ? 'Enlaces rápidos de servicios' : 'Service quick links') ?>">
            <a class="service-hotspot-all" href="<?= e(localized_url('services')) ?>"><?= e(setting_value($settings, 'services_kicker_label', 'View all')) ?></a>
            <a class="service-hotspot-filter" href="<?= e(localized_url('services')) ?>"><?= e(setting_value($settings, 'services_filter_label', 'Products & Services')) ?></a>
            <?php foreach (array_slice($services, 0, 4) as $index => $service): ?>
                <a class="service-hotspot-<?= e((string) ($index + 1)) ?>" href="<?= e(localized_url('services/' . $service['slug'])) ?>"><?= e($service['title']) ?></a>
            <?php endforeach; ?>
        </nav>
    <?php endif; ?>
</section>
<?php $homeContactStage = true; ?>
<?php include base_path('resources/views/public/partials/contact_block.php'); ?>
<?php $homeNewsletterStage = true; ?>
<?php include base_path('resources/views/public/partials/newsletter.php'); ?>
