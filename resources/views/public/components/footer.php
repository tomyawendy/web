<footer class="site-footer">
    <div class="container footer-shell">
        <div class="footer-brand">
            <img class="footer-brand-logo" src="<?= e(asset_url(current_locale() === 'es' ? 'figma/logo-footer-full.png' : 'figma/logo-footer.png')) ?>" alt="<?= e(setting_value($settings ?? [], 'site_name', 'Planet Aviation')) ?>">
        </div>
        <div class="footer-links footer-columns">
            <div class="footer-column">
                <span class="footer-title"><?= e(setting_value($settings ?? [], 'footer_pages_title', 'Pages')) ?></span>
                <a href="<?= e(localized_url('insights')) ?>"><?= e(setting_value($settings ?? [], 'footer_events_label', 'Events')) ?></a>
                <a href="<?= e(localized_url('insights')) ?>"><?= e(setting_value($settings ?? [], 'footer_awards_label', 'Our awards')) ?></a>
            </div>
            <div class="footer-column">
                <span class="footer-title"><?= e(setting_value($settings ?? [], 'footer_services_title', 'Services')) ?></span>
                <a href="<?= e(localized_url('contact')) ?>"><?= e(setting_value($settings ?? [], 'footer_contact_label', 'Contact')) ?></a>
                <a href="<?= e(localized_url('insights')) ?>"><?= e(setting_value($settings ?? [], 'footer_news_label', 'News')) ?></a>
            </div>
            <div class="footer-column">
                <span class="footer-title"><?= e(setting_value($settings ?? [], 'footer_about_title', 'About')) ?></span>
                <a href="<?= e(localized_url('about')) ?>"><?= e(setting_value($settings ?? [], 'footer_certification_label', 'IATA certification')) ?></a>
            </div>
        </div>
        <div class="footer-cert">
            <span class="footer-title"><?= e(setting_value($settings ?? [], 'footer_certification_label', 'Obtain IATA certification')) ?></span>
            <img class="footer-cert-mark" src="<?= e(asset_url(current_locale() === 'es' ? 'figma/cert-mark-es.svg' : 'figma/cert-mark.png')) ?>" alt="<?= e(current_locale() === 'es' ? 'Certificación IATA' : 'IATA Certification') ?>">
        </div>
    </div>
    <div class="footer-copy">
        <div class="container">
            <?= e(setting_value($settings ?? [], 'footer_copyright', 'Copyright © Planet Service. All Rights Reserved')) ?>
        </div>
    </div>
</footer>
