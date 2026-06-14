<section class="why-section"<?= raw_background_style(setting_value($settings, 'why_background_image'), 'linear-gradient(rgba(12,42,93,0.90), rgba(12,42,93,0.90))') ?>>
    <div class="container">
        <div class="why-shell">
            <h2><?= e(setting_value($settings, 'why_heading', 'Why Partners Choose Us')) ?></h2>
            <div class="why-grid">
                <?php
                $whyDescriptions = [
                    'Independent GSSA' => 'Neutral and flexible representation across multiple airlines. Experienced sales teams with strong local market knowledge.',
                    'Strong Financial Background' => 'Dedicated revenue accounting teams across the globe. Controlled invoicing and full participation in IATA CASS.',
                    'Digital Marketing' => 'Dynamic marketing strategies to promote airline brand. Creative promotions and key air cargo exhibition attendance.',
                    'Motivated & Experienced Teams' => 'Fully trained cargo handling and airline systems teams. Real-time updates on schedules, capacity, and revenue.',
                    'Business Intelligence' => 'Data analysis collected in quote and supervision platforms. Business intelligence tools support operational decisions.',
                    'Full Service - Sales to Invoicing' => 'End-to-end cargo sales, booking, and documentation. Compliance, claims support, and financial reconciliation.',
                ];
                ?>
                <?php foreach (array_slice(setting_lines($settings, 'why_items'), 0, 6) as $item): ?>
                    <article>
                        <span></span>
                        <h3><?= e($item) ?></h3>
                        <p><?= e($whyDescriptions[$item] ?? '') ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
