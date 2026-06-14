<!DOCTYPE html>
<html lang="<?= e(current_locale()) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($metaTitle ?? site_name($settings ?? [])) ?></title>
    <link rel="stylesheet" href="<?= e(asset_url('css/design-tokens.css') . '?v=20260614b') ?>">
    <link rel="stylesheet" href="<?= e(asset_url('css/site-main.css') . '?v=20260614b') ?>">
</head>
<body class="site-body">
<?php include base_path('resources/views/public/components/header.php'); ?>
<main>
    <?= $content ?>
</main>
<?php include base_path('resources/views/public/components/footer.php'); ?>
</body>
</html>
