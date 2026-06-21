<?php
$servicesHeading = setting_value($settings, 'services_heading', "Delivering Service\nExcellence");
$servicesHeadingParts = preg_split("/\R+/", $servicesHeading, 2) ?: [$servicesHeading];
$defaultServices = [
    [
        'slug' => 'general-sales-service-agent',
        'title' => 'General Sales & Service Agent',
        'summary' => 'PLANET AVIATION, S.L. is a globally recognized General Sales & Service Agent (GSSA) headquartered in Europe, dedicated to bridging the gap between complex logistics needs and streamlined execution.',
        'content' => "<li>Delivered 1,200,000+ tons of cargo worldwide</li><li>Dynamic capacity allocation for maximum yield optimization</li><li>Consistent achievement and surpassing of airline sales targets</li>",
        'cover_image' => 'service_2.png',
    ],
    [
        'slug' => 'air-cargo-consolidation-experts',
        'title' => 'Air Cargo Consolidation Experts',
        'summary' => 'Strategic capacity optimization and rapid consolidation solutions.',
        'content' => "<li>Strategic Capacity Optimization: maximizing cubic yield</li><li>Precise Capacity Management: effective route utilization</li><li>Dynamic Payload Adjustments: real-time flexibility</li><li>Rapid Air Consolidation Solutions: fast turnaround groupings</li>",
        'cover_image' => 'service_4.png',
    ],
    [
        'slug' => 'handling-trucking',
        'title' => 'Handling & Trucking',
        'summary' => 'Ground handling and transport support services.',
        'content' => "<li>Strong ground handling with super service</li><li>Cost-effective handling & trucking solutions</li><li>Import handling and administration services</li>",
        'cover_image' => 'about-photo.png',
    ],
    [
        'slug' => 'insurance-solutions',
        'title' => 'Air Cargo Logistics Insurance Solutions',
        'summary' => 'Comprehensive cargo insurance packages designed to provide robust risk prevention and loss compensation.',
        'content' => "<li>Comprehensive coverage for cargo exposure</li><li>Flexible policy options for all shipment types</li><li>Fast claims processing</li>",
        'cover_image' => '',
        'visual_variant' => 'insurance',
    ],
];
$serviceCards = array_values($services ?? []);
for ($i = 0; $i < 4; $i++) {
    $serviceCards[$i] = array_merge($defaultServices[$i], $serviceCards[$i] ?? []);
}
?>
<section class="service-overview">
    <div class="container">
        <?php
        $headingTitle = $servicesHeadingParts[0] ?? $servicesHeading;
        if (!empty($servicesHeadingParts[1])) {
            $headingTitle .= "\n" . $servicesHeadingParts[1];
        }
        $headingDescription = setting_value($settings, 'services_intro', 'Planet Aviation offers a comprehensive portfolio of air cargo products and services. Every shipment is handled with precision, care, and professionalism.');
        include base_path('resources/views/public/components/section_heading.php');
        ?>
        <div class="home-services-list">
            <?php foreach ($serviceCards as $index => $service): ?>
                <?php
                $serviceItems = array_slice(content_list_items($service['content'] ?? ''), 0, 4);
                $serviceVisualClass = 'home-service-visual';
                if (($service['visual_variant'] ?? '') === 'insurance') {
                    $serviceVisualClass .= ' home-service-visual-insurance';
                }
                ?>
                <article class="home-service-row" id="service-<?= e($service['slug']) ?>">
                    <div class="home-service-copy">
                        <span class="home-service-index"><?= e(sprintf('%02d', $index + 1)) ?></span>
                        <h3><?= e($service['title']) ?></h3>
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
                    <div class="<?= e($serviceVisualClass) ?>"<?= background_style($service['cover_image'] ?? '') ?>></div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
