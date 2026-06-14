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
