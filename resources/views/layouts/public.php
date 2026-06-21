<!DOCTYPE html>
<html lang="<?= e(current_locale()) ?>">
<head>
    <?php
    $publicSettings = $settings ?? [];
    $resolvedMetaTitle = $metaTitle ?? setting_value($publicSettings, 'site_meta_title', site_name($publicSettings));
    $resolvedMetaDescription = $metaDescription ?? setting_value($publicSettings, 'site_meta_description');
    $resolvedMetaKeywords = $metaKeywords ?? setting_value($publicSettings, 'site_meta_keywords');
    $resolvedMetaImage = $metaImage ?? setting_value($publicSettings, 'site_og_image');
    $resolvedCanonical = localized_current_url(current_locale());
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($resolvedMetaTitle) ?></title>
    <?php if (!empty($resolvedMetaDescription)): ?>
        <meta name="description" content="<?= e((string) $resolvedMetaDescription) ?>">
        <meta property="og:description" content="<?= e((string) $resolvedMetaDescription) ?>">
        <meta name="twitter:description" content="<?= e((string) $resolvedMetaDescription) ?>">
    <?php endif; ?>
    <?php if (!empty($resolvedMetaKeywords)): ?>
        <meta name="keywords" content="<?= e((string) $resolvedMetaKeywords) ?>">
    <?php endif; ?>
    <meta property="og:title" content="<?= e($resolvedMetaTitle) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= e($resolvedCanonical) ?>">
    <meta name="twitter:title" content="<?= e($resolvedMetaTitle) ?>">
    <?php if (!empty($resolvedMetaImage)): ?>
        <meta property="og:image" content="<?= e(media_url((string) $resolvedMetaImage)) ?>">
    <?php endif; ?>
    <link rel="canonical" href="<?= e($resolvedCanonical) ?>">
    <link rel="alternate" hreflang="en" href="<?= e(localized_current_url('en')) ?>">
    <link rel="alternate" hreflang="es" href="<?= e(localized_current_url('es')) ?>">
    <link rel="alternate" hreflang="x-default" href="<?= e(localized_current_url('en')) ?>">
    <link rel="stylesheet" href="<?= e(asset_url('css/design-tokens.css') . '?v=20260617b') ?>">
    <link rel="stylesheet" href="<?= e(asset_url('css/site-main.css') . '?v=20260621j') ?>">
    <link rel="preload" href="<?= e(asset_url('figma/world-map-noedge.png')) ?>" as="image">
    <link rel="preload" href="<?= e(asset_url('figma/news-1.png')) ?>" as="image">
    <link rel="preload" href="<?= e(asset_url('figma/news-2-noedge.png')) ?>" as="image">
    <link rel="preload" href="<?= e(asset_url('figma/news-3-noedge.png')) ?>" as="image">
    <link rel="preload" href="<?= e(asset_url('figma/service-1-stage.png')) ?>" as="image">
    <link rel="preload" href="<?= e(asset_url('figma/service-2-stage.png')) ?>" as="image">
    <link rel="preload" href="<?= e(asset_url('figma/service-3-stage.png')) ?>" as="image">
    <link rel="preload" href="<?= e(asset_url('figma/service-4-stage.png')) ?>" as="image">
    <link rel="preload" href="<?= e(asset_url('figma/contact-photo.png')) ?>" as="image">
    <link rel="preload" href="<?= e(asset_url('figma/newsletter-bg.png')) ?>" as="image">
</head>
<body class="site-body">
<?php include base_path('resources/views/public/components/header.php'); ?>
<main>
    <?= $content ?>
</main>
<?php include base_path('resources/views/public/components/footer.php'); ?>
</body>
</html>
