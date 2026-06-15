<?php
$aboutContent = resolved_translation($aboutPage ?? null);
$regions = setting_lines($settings, 'world_regions');
$partners = setting_media_pairs($settings, 'partners_logos');
if ($partners === []) {
    $partners = array_map(static fn (string $partner): array => ['label' => $partner, 'path' => ''], setting_lines($settings, 'partners_list'));
}
$heroButtonText = $heroBanner['button_text'] ?? setting_value($settings, 'hero_button_text', 'LEARN MORE');
$heroTitle = $heroBanner['title'] ?? setting_value($settings, 'homepage_title', "Premium Choice\nfor Air Logistics Solution!");
$heroSubtitle = $heroBanner['subtitle'] ?? setting_value($settings, 'homepage_subtitle', '');
$servicesHeading = setting_value($settings, 'services_heading', "Delivering Service\nExcellence");
$homeAboutBodyDefault = "PLANET AVIATION, S.L., is a globally recognized Europe General Sales & Service Agent (GSSA). We utilize our wide range of highlyspecialized services to design and deliver tailor-made solutions for ultimate customer by applying our extensive local knowledgeto maximize the results of customer forwarders.\n\nWe are defning the GSSA expertise by our strategy with Commercialization, Technology, Solution and Sustainability. Facing the apid upgrading of dicital transformation invest in our own market dicitalisation team to connect with the e-CARCOWARE,strengthening user-friendly interface on online booking,revenue accounting,truckking management,online tracking,etc.";
$servicesHeadingParts = preg_split("/\R+/", $servicesHeading, 2) ?: [$servicesHeading];
if (strpos($heroTitle, "\n") === false && preg_match('/^Premium Choice for Air Logistics Solution!?$/i', trim($heroTitle))) {
    $heroTitle = "Premium Choice\nFor Air Logistics\nSolution!";
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

<section class="lookup-strip" id="services">
    <div class="container">
        <p><?= e(setting_value($settings, 'lookup_label', "I'm looking for")) ?></p>
        <div class="lookup-pills">
            <?php foreach (array_slice($services, 0, 4) as $index => $service): ?>
                <?php $lookupTitle = $index === 3 ? setting_value($settings, 'lookup_insurance_label', 'Insurance') : $service['title']; ?>
                <a href="<?= e(app_url('services/' . $service['slug'])) ?>"><?= e($lookupTitle) ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="home-about-section" id="about">
    <div class="container home-about-shell">
        <div class="home-about-copy">
            <h2><?= e(setting_value($settings, 'home_about_heading', 'Your Leading Air Cargo Sales & Service Provider')) ?></h2>
            <p><?= nl2br(e(setting_value($settings, 'home_about_body', $homeAboutBodyDefault))) ?></p>
            <a class="hero-button mini" href="<?= e(app_url('about')) ?>"><?= e(setting_value($settings, 'home_about_button', 'LEARN MORE')) ?></a>
        </div>
        <div class="home-about-visual"<?= background_style($aboutPage['seo_image'] ?? '') ?>></div>
    </div>
    <a class="about-hotspot" href="<?= e(app_url('about')) ?>"><?= e(setting_value($settings, 'home_about_button', 'LEARN MORE')) ?></a>
</section>

<section class="service-overview">
    <div class="container">
        <div class="service-head services-page-head home-services-head">
            <div>
                <span class="tiny-link"><?= e(setting_value($settings, 'services_kicker_label', 'View all')) ?></span>
                <a class="services-filter-link" href="<?= e(app_url('services')) ?>"><?= e(setting_value($settings, 'services_filter_label', 'Products & Services')) ?></a>
                <h2><span class="home-services-nowrap"><?= e($servicesHeadingParts[0] ?? $servicesHeading) ?></span><?php if (!empty($servicesHeadingParts[1])): ?><br><?= e($servicesHeadingParts[1]) ?><?php endif; ?></h2>
            </div>
            <p><?= e(setting_value($settings, 'services_intro', 'Planet Aviation offers a comprehensive portfolio of air cargo products and services. Every shipment is handled with precision, care, and professionalism, ensuring reliability at every stage of the logistics chain.')) ?></p>
        </div>
        <div class="home-services-list">
            <?php foreach (array_slice($services, 0, 4) as $index => $service): ?>
                <?php $serviceItems = array_slice(content_list_items($service['content'] ?? ''), 0, 4); ?>
                <?php $serviceVisual = $service['cover_image'] ?? ''; ?>
                <?php $figmaServiceVisual = 'figma/service-' . ($index + 1) . '-crop.png'; ?>
                <?php $usesLegacyFigmaSeed = preg_match('#^assets/figma/service_[24]\.png$#', $serviceVisual) === 1; ?>
                <?php $serviceVisualStyle = ($serviceVisual !== '' && !$usesLegacyFigmaSeed) ? background_style($serviceVisual) : ' style="background-image:url(' . e(asset_url($figmaServiceVisual)) . ')"'; ?>
                <article class="home-service-row" id="service-<?= e($service['slug']) ?>">
                    <div class="home-service-copy">
                        <span class="home-service-index"><?= e(sprintf('%02d', $index + 1)) ?></span>
                        <?php $serviceTitle = ($index === 3 && current_locale() !== 'es') ? setting_value($settings, 'services_fourth_home_title', 'General Sales & Service Agent') : $service['title']; ?>
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
                        <a class="hero-button mini" href="<?= e(app_url('services/' . $service['slug'])) ?>"><?= e(setting_value($settings, 'services_learn_more_label', 'LEARN MORE')) ?></a>
                    </div>
                    <div class="home-service-visual"<?= $serviceVisualStyle ?>></div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
    <nav class="service-hotspots" aria-label="Service quick links">
        <a class="service-hotspot-all" href="<?= e(app_url('services')) ?>"><?= e(setting_value($settings, 'services_kicker_label', 'View all')) ?></a>
        <a class="service-hotspot-filter" href="<?= e(app_url('services')) ?>"><?= e(setting_value($settings, 'services_filter_label', 'Products & Services')) ?></a>
        <?php foreach (array_slice($services, 0, 4) as $index => $service): ?>
            <a class="service-hotspot-<?= e((string) ($index + 1)) ?>" href="<?= e(app_url('services/' . $service['slug'])) ?>"><?= e($service['title']) ?></a>
        <?php endforeach; ?>
    </nav>
</section>

<section class="why-section">
    <div class="container">
        <div class="why-shell">
            <h2><?= e(setting_value($settings, 'why_heading', 'Why Partners Choose Us')) ?></h2>
            <div class="why-grid">
                <?php foreach (array_slice(setting_lines($settings, 'why_items'), 0, 6) as $item): ?>
                    <article>
                        <span></span>
                        <p><?= e($item) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<section class="world-section">
    <div class="container world-shell">
        <div>
            <span class="tiny-link"><?= e(setting_value($settings, 'world_kicker_label', 'GLOBAL MANAGEMENT. LOCAL EXPERTISE.')) ?></span>
            <h2><?= e(setting_value($settings, 'world_heading', 'One World')) ?></h2>
            <p><?= e(setting_value($settings, 'world_intro', 'Local expertise, global cargo reach, and responsive support.')) ?></p>
            <div class="region-list">
                <?php foreach ($regions as $region): ?>
                    <span><?= e($region) ?></span>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="world-map-card">
            <div class="world-map"<?= background_style(setting_value($settings, 'world_map_image')) ?>></div>
            <div class="stats-row">
                <article><strong><?= e(setting_value($settings, 'stats_offices', '100+')) ?></strong><span><?= e(setting_value($settings, 'stats_offices_label', 'Global Partners')) ?></span></article>
                <article><strong><?= e(setting_value($settings, 'stats_support', '24/7')) ?></strong><span><?= e(setting_value($settings, 'stats_support_label', 'Rapid Response Team')) ?></span></article>
                <article><strong><?= e(setting_value($settings, 'stats_shipments', '16,000+')) ?></strong><span><?= e(setting_value($settings, 'stats_shipments_label', 'Freight Forwarders')) ?></span></article>
            </div>
        </div>
    </div>
</section>

<section class="partners-section">
    <div class="container">
        <h2><?= e(setting_value($settings, 'partners_heading', 'Our Partners')) ?></h2>
        <p class="partners-subtitle"><?= e(setting_value($settings, 'partners_subtitle', 'These are our collaborators')) ?></p>
        <div class="partner-strip">
            <?php foreach ($partners as $partner): ?>
                <span>
                    <?php if (($partner['path'] ?? '') !== ''): ?>
                        <img src="<?= e(media_url($partner['path'])) ?>" alt="<?= e($partner['label'] ?? 'Partner') ?>">
                    <?php else: ?>
                        <?= e($partner['label'] ?? '') ?>
                    <?php endif; ?>
                </span>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="news-section home-news-stage" id="insights">
    <div class="container">
        <div class="service-head">
            <div>
                <span class="tiny-link"><?= e(setting_value($settings, 'news_kicker_label', 'INSIGHT')) ?></span>
                <h2><?= e(setting_value($settings, 'news_heading', 'Latest News')) ?></h2>
            </div>
            <a class="news-link" href="<?= e(app_url('insights')) ?>"><?= e(setting_value($settings, 'news_view_all_label', 'VIEW ALL ARTICLES')) ?></a>
        </div>
        <div class="news-grid">
            <?php foreach ($news as $item): ?>
                <article class="news-card" id="news-<?= e($item['slug']) ?>">
                    <div class="news-thumb"<?= background_style($item['cover_image'] ?? '') ?>></div>
                    <span><?= e(format_datetime($item['published_at'])) ?></span>
                    <h3><?= e($item['title']) ?></h3>
                    <p><?= e($item['excerpt']) ?></p>
                    <a class="news-link" href="<?= e(app_url('insights/' . $item['slug'])) ?>"><?= e(setting_value($settings, 'read_more_label', 'READ MORE')) ?></a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php $homeContactStage = true; ?>
<?php include base_path('resources/views/public/partials/contact_block.php'); ?>
<?php $homeNewsletterStage = true; ?>
<?php include base_path('resources/views/public/partials/newsletter.php'); ?>
