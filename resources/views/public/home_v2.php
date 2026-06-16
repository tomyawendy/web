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
$isSpanishHome = current_locale() === 'es';
if (strpos($heroTitle, "\n") === false && preg_match('/^Premium Choice for Air Logistics Solution!?$/i', trim($heroTitle))) {
    $heroTitle = "Premium Choice\nFor Air Logistics\nSolution!";
}
if ($isSpanishHome && !preg_match('/[!?]$/', trim($heroTitle))) {
    $heroTitle .= '!';
}
$homeAboutHeading = setting_value($settings, 'home_about_heading', 'Your Leading Air Cargo Sales & Service Provider');
$homeAboutBody = setting_value($settings, 'home_about_body', $homeAboutBodyDefault);
$servicesIntro = setting_value($settings, 'services_intro', 'Planet Aviation offers a comprehensive portfolio of air cargo products and services. Every shipment is handled with precision, care, and professionalism, ensuring reliability at every stage of the logistics chain.');
$whyHeading = setting_value($settings, 'why_heading', 'Why Partners Choose Us');
$whyCards = array_map(static fn (string $item): array => ['icon' => '', 'title' => $item, 'body' => ''], array_slice(setting_lines($settings, 'why_items'), 0, 6));
$worldKicker = setting_value($settings, 'world_kicker_label', 'GLOBAL MANAGEMENT. LOCAL EXPERTISE.');
$worldHeading = setting_value($settings, 'world_heading', 'One World');
$worldIntro = setting_value($settings, 'world_intro', 'Local expertise, global cargo reach, and responsive support.');
$worldRegionGroups = [];
$worldNote = 'Local Expertise, Global Reach: Your Strategic Gateway to South America & Africa.';

if ($isSpanishHome) {
    $homeAboutHeading = 'Su socio líder en ventas y servicios de carga aérea';
    $homeAboutBody = "PLANET AVIATION, S.L. es un Agente General de Ventas y Servicios (GSSA) europeo reconocido a nivel global. Utilizamos una amplia gama de servicios altamente especializados para diseñar y entregar soluciones a medida, aplicando nuestro profundo conocimiento local para maximizar los resultados de los transitarios.\n\nDefinimos nuestra experiencia GSSA mediante una estrategia basada en comercialización, tecnología, soluciones y sostenibilidad. Ante la rápida evolución de la transformación digital, invertimos en nuestro propio equipo de digitalización de mercado para conectar con e-CARGOWARE, fortaleciendo interfaces fáciles de usar para reservas en línea, contabilidad de ingresos, gestión de transporte terrestre y seguimiento en línea.";
    $servicesIntro = 'Planet Aviation ofrece una cartera integral de productos y servicios de carga aérea. Cada envío se gestiona con precisión, cuidado y profesionalidad, garantizando fiabilidad en cada etapa de la cadena logística.';
    $whyHeading = 'Por qué nos eligen';
    $whyCards = [
        ['icon' => 'shield', 'title' => 'GSSA independiente', 'body' => 'Representación neutral y flexible para múltiples aerolíneas. Equipos comerciales con sólido conocimiento local. Rendimiento orientado por datos y estrategias a medida.'],
        ['icon' => 'bank', 'title' => 'Sólida base financiera', 'body' => 'Equipos dedicados de revenue accounting en todo el mundo. Facturación controlada y participación completa en IATA CASS. Captura y verificación de datos con soporte back-office.'],
        ['icon' => 'megaphone', 'title' => 'Marketing digital', 'body' => 'Estrategias dinámicas para promover la marca de la aerolínea. Promociones creativas, reportes de mercado y asistencia a eventos clave de carga aérea.'],
        ['icon' => 'team', 'title' => 'Equipos motivados y experimentados', 'body' => 'Formación completa en sistemas de handling especial y aerolíneas. Actualizaciones en tiempo real de horarios, capacidad e ingresos. Interfaces de reserva integradas con plataformas aéreas.'],
        ['icon' => 'chart', 'title' => 'Inteligencia comercial', 'body' => 'Análisis de datos recogidos en plataformas de cotización y supervisión. Uso de herramientas de business intelligence para la gestión. Inversión continua en infraestructura IT y digitalización.'],
        ['icon' => 'layers', 'title' => 'Servicio integral: de ventas a facturación', 'body' => 'Ventas, reservas y documentación de carga de extremo a extremo. Cumplimiento, soporte de reclamaciones y conciliación financiera. Solución integral que asegura consistencia y eficiencia.'],
    ];
    $worldKicker = 'GESTIÓN GLOBAL. EXPERIENCIA LOCAL.';
    $worldHeading = 'Un solo mundo';
    $worldIntro = 'Experiencia local, alcance global de carga aérea y soporte ágil para cada mercado.';
    $worldRegionGroups = [
        ['title' => 'Américas', 'items' => ['Estados Unidos', 'Canadá', 'México', 'Colombia', 'Ecuador', 'Perú', 'Bolivia', 'Brasil', 'Uruguay', 'Paraguay', 'Argentina', 'Chile', 'Panamá', 'Costa Rica', 'Nicaragua']],
        ['title' => 'Europa', 'items' => ['Alemania', 'Suiza', 'España', 'Portugal', 'Austria']],
        ['title' => 'Oriente Medio', 'items' => ['Turquía', 'EAU']],
        ['title' => 'África', 'items' => ['Sudáfrica', 'Mozambique']],
        ['title' => 'Asia-Pacífico', 'items' => ['China', 'India']],
    ];
    $worldNote = 'Experiencia local, alcance global: su puerta estratégica hacia Sudamérica y África.';
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
            <h2><?= e($homeAboutHeading) ?></h2>
            <p><?= nl2br(e($homeAboutBody)) ?></p>
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
            <p><?= e($servicesIntro) ?></p>
        </div>
        <div class="home-services-list">
            <?php foreach (array_slice($services, 0, 4) as $index => $service): ?>
                <?php $serviceItems = array_slice(content_list_items($service['content'] ?? ''), 0, 4); ?>
                <?php $serviceVisual = $service['cover_image'] ?? ''; ?>
                <?php $figmaServiceVisual = $index === 3 ? 'figma/service_4.png' : 'figma/service-' . ($index + 1) . '-crop.png'; ?>
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
            <h2><?= e($whyHeading) ?></h2>
            <div class="why-grid">
                <?php foreach ($whyCards as $card): ?>
                    <article>
                        <span class="why-icon why-icon-<?= e($card['icon']) ?>"></span>
                        <?php if (($card['body'] ?? '') !== ''): ?>
                            <h3><?= e($card['title']) ?></h3>
                            <p><?= e($card['body']) ?></p>
                        <?php else: ?>
                            <p><?= e($card['title']) ?></p>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<section class="world-section">
    <div class="container world-shell">
        <div>
            <span class="tiny-link"><?= e($worldKicker) ?></span>
            <h2><?= e($worldHeading) ?></h2>
            <p><?= e($worldIntro) ?></p>
            <div class="region-list">
                <?php if ($worldRegionGroups !== []): ?>
                    <?php foreach ($worldRegionGroups as $group): ?>
                        <article class="region-group">
                            <strong><?= e($group['title']) ?></strong>
                            <?php foreach ($group['items'] as $region): ?>
                                <span><?= e($region) ?></span>
                            <?php endforeach; ?>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php foreach ($regions as $region): ?>
                        <span><?= e($region) ?></span>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="world-map-card">
            <div class="world-note"><span></span><p><?= e($worldNote) ?></p></div>
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
