<?php
$currentPath = request_path();
$isHome = $currentPath === '/';
$isAbout = $currentPath === '/about' || str_starts_with($currentPath, '/page/about');
$isServices = str_starts_with($currentPath, '/services');
$isInsights = str_starts_with($currentPath, '/insights') || str_starts_with($currentPath, '/news');
$isContact = $currentPath === '/contact';
$locales = config('app.locales', []);
$activeLocale = current_locale();
$activeLocaleLabel = $locales[$activeLocale] ?? 'English';
?>
<header class="site-header">
    <div class="container nav-shell">
        <a class="brand" href="<?= e(app_url()) ?>">
            <img class="brand-logo" src="<?= e(asset_url('figma/logo-header.png')) ?>" alt="<?= e(setting_value($settings ?? [], 'site_name', 'Planet Aviation')) ?>">
        </a>
        <nav class="site-nav">
            <a class="<?= $isHome ? 'active' : '' ?>" href="<?= e(app_url()) ?>"><?= e(setting_value($settings ?? [], 'nav_home_label', 'Home')) ?></a>
            <a class="<?= $isAbout ? 'active' : '' ?>" href="<?= e(app_url('about')) ?>"><?= e(setting_value($settings ?? [], 'nav_about_label', 'Who We Are?')) ?></a>
            <a class="<?= $isServices ? 'active' : '' ?>" href="<?= e(app_url('services')) ?>"><?= e(setting_value($settings ?? [], 'nav_services_label', 'Our Services')) ?></a>
            <a class="<?= $isInsights ? 'active' : '' ?>" href="<?= e(app_url('insights')) ?>"><?= e(setting_value($settings ?? [], 'nav_insights_label', 'Insights')) ?></a>
            <a class="<?= $isContact ? 'active' : '' ?>" href="<?= e(app_url('contact')) ?>"><?= e(setting_value($settings ?? [], 'nav_contact_label', 'Contact')) ?></a>
        </nav>
        <div class="nav-tools">
            <a class="quote-button" href="<?= e(app_url('contact')) ?>"><?= e(setting_value($settings ?? [], 'nav_quote_label', 'GET A QUOTE')) ?></a>
            <div class="locale-switch">
                <span class="locale-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" role="presentation" focusable="false">
                        <circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.6"></circle>
                        <ellipse cx="12" cy="12" rx="4.2" ry="9" fill="none" stroke="currentColor" stroke-width="1.4"></ellipse>
                        <path d="M3 12h18M12 3c2.8 2.5 4.4 5.5 4.4 9s-1.6 6.5-4.4 9c-2.8-2.5-4.4-5.5-4.4-9S9.2 5.5 12 3Z" fill="none" stroke="currentColor" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </span>
                <button class="locale-current" type="button" aria-haspopup="true" aria-expanded="false">
                    <span><?= e($activeLocaleLabel) ?></span>
                    <span class="locale-caret" aria-hidden="true">+</span>
                </button>
                <div class="locale-links" aria-label="Language selector">
                    <?php foreach ($locales as $localeCode => $localeName): ?>
                        <a href="<?= e($currentPath . '?lang=' . $localeCode) ?>" class="<?= $activeLocale === $localeCode ? 'active' : '' ?>"><?= e($localeName) ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</header>
