<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($metaTitle ?? 'Admin Login') ?></title>
    <link rel="stylesheet" href="<?= e(asset_url('css/admin.css')) ?>">
</head>
<body class="admin-auth-body">
    <?= $content ?>
</body>
</html>
