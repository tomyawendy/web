<footer class="site-footer">
    <?php $isSpanishFooter = current_locale() === 'es'; ?>
    <div class="container footer-shell">
        <div class="footer-brand">
            <img class="footer-brand-logo" src="<?= e(asset_url(current_locale() === 'es' ? 'figma/logo-footer-full.png' : 'figma/logo-footer.png')) ?>" alt="<?= e(setting_value($settings ?? [], 'site_name', 'Planet Aviation')) ?>">
        </div>
        <div class="footer-links footer-columns">
            <div class="footer-column">
                <span class="footer-title"><?= e($isSpanishFooter ? 'Paginas' : setting_value($settings ?? [], 'footer_pages_title', 'Pages')) ?></span>
                <a href="<?= e(localized_url('insights')) ?>"><?= e($isSpanishFooter ? 'Eventos' : setting_value($settings ?? [], 'footer_events_label', 'Events')) ?></a>
                <a href="<?= e(localized_url('insights')) ?>"><?= e($isSpanishFooter ? 'Reconocimientos' : setting_value($settings ?? [], 'footer_awards_label', 'Our awards')) ?></a>
            </div>
            <div class="footer-column">
                <span class="footer-title"><?= e($isSpanishFooter ? 'Servicios' : setting_value($settings ?? [], 'footer_services_title', 'Services')) ?></span>
                <a href="<?= e(localized_url('contact')) ?>"><?= e($isSpanishFooter ? 'Contacto' : setting_value($settings ?? [], 'footer_contact_label', 'Contact')) ?></a>
                <a href="<?= e(localized_url('insights')) ?>"><?= e($isSpanishFooter ? 'Noticias' : setting_value($settings ?? [], 'footer_news_label', 'News')) ?></a>
            </div>
            <div class="footer-column">
                <span class="footer-title"><?= e($isSpanishFooter ? 'Acerca de' : setting_value($settings ?? [], 'footer_about_title', 'About')) ?></span>
                <a href="<?= e(localized_url('about')) ?>"><?= e($isSpanishFooter ? 'Obtener certificacion IATA' : setting_value($settings ?? [], 'footer_certification_label', 'IATA certification')) ?></a>
            </div>
        </div>
        <div class="footer-cert">
            <span class="footer-title"><?= e($isSpanishFooter ? 'Obtener certificacion IATA' : setting_value($settings ?? [], 'footer_certification_label', 'Obtain IATA certification')) ?></span>
            <img class="footer-cert-mark" src="<?= e(asset_url(current_locale() === 'es' ? 'figma/cert-mark-es.svg' : 'figma/cert-mark.png')) ?>" alt="<?= e(current_locale() === 'es' ? 'Certificación IATA' : 'IATA Certification') ?>">
        </div>
    </div>
    <div class="footer-copy">
        <div class="container">
            <?= e($isSpanishFooter ? 'Copyright (c) Planet Aviation. Todos los derechos reservados.' : setting_value($settings ?? [], 'footer_copyright', 'Copyright (c) Planet Service. All Rights Reserved')) ?>
        </div>
    </div>
</footer>
