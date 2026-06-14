<section class="partners-section">
    <div class="container">
        <?php
        $headingTitle = setting_value($settings, 'partners_heading', 'Our Partners');
        $headingDescription = setting_value($settings, 'partners_subtitle', 'These are our collaborators');
        $headingCenter = true;
        include base_path('resources/views/public/components/section_heading.php');
        ?>
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
