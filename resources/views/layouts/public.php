<!DOCTYPE html>
<html lang="<?= e(current_locale()) ?>">
<head>
    <?php
    $publicSettings = $settings ?? [];
    $resolvedMetaTitle = $metaTitle ?? setting_value($publicSettings, 'site_meta_title', site_name($publicSettings));
    $resolvedMetaDescription = $metaDescription ?? setting_value($publicSettings, 'site_meta_description');
    $resolvedMetaKeywords = $metaKeywords ?? setting_value($publicSettings, 'site_meta_keywords');
    $resolvedMetaImage = $metaImage ?? setting_value($publicSettings, 'site_og_image');
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($resolvedMetaTitle) ?></title>
    <?php if (!empty($resolvedMetaDescription)): ?>
        <meta name="description" content="<?= e((string) $resolvedMetaDescription) ?>">
        <meta property="og:description" content="<?= e((string) $resolvedMetaDescription) ?>">
    <?php endif; ?>
    <?php if (!empty($resolvedMetaKeywords)): ?>
        <meta name="keywords" content="<?= e((string) $resolvedMetaKeywords) ?>">
    <?php endif; ?>
    <meta property="og:title" content="<?= e($resolvedMetaTitle) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= e(app_url(ltrim(request_path(), '/'))) ?>">
    <?php if (!empty($resolvedMetaImage)): ?>
        <meta property="og:image" content="<?= e(media_url((string) $resolvedMetaImage)) ?>">
    <?php endif; ?>
    <link rel="stylesheet" href="<?= e(asset_url('css/design-tokens.css') . '?v=20260615g') ?>">
    <link rel="stylesheet" href="<?= e(asset_url('css/site-main.css') . '?v=20260615g') ?>">
</head>
<body class="site-body">
<?php include base_path('resources/views/public/components/header.php'); ?>
<main>
    <?= $content ?>
</main>
<?php include base_path('resources/views/public/components/footer.php'); ?>
</body>
</html>
