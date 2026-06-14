<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($metaTitle ?? 'Admin') ?></title>
    <link rel="stylesheet" href="<?= e(asset_url('css/admin.css')) ?>">
</head>
<body class="admin-body">
<?php $flashMessage = flash(); $user = admin_user(); ?>
<div class="admin-shell">
    <aside class="admin-sidebar">
        <div class="admin-logo">
            <strong>Planet Aviation</strong>
            <span>CMS</span>
        </div>
        <nav>
            <a href="<?= e(admin_url()) ?>">Dashboard</a>
            <?php if (admin_can('manage_pages')): ?><a href="<?= e(admin_url('pages')) ?>">Content Pages</a><?php endif; ?>
            <?php if (admin_can('manage_services')): ?><a href="<?= e(admin_url('services')) ?>">Service Cards</a><?php endif; ?>
            <?php if (admin_can('manage_posts')): ?><a href="<?= e(admin_url('posts?type=news')) ?>">Insights</a><?php endif; ?>
            <?php if (admin_can('manage_posts')): ?><a href="<?= e(admin_url('posts?type=document')) ?>">Documents</a><?php endif; ?>
            <?php if (admin_can('manage_banners')): ?><a href="<?= e(admin_url('banners')) ?>">Hero Banners</a><?php endif; ?>
            <?php if (admin_can('manage_media')): ?><a href="<?= e(admin_url('media')) ?>">Media</a><?php endif; ?>
            <?php if (admin_can('view_contacts')): ?><a href="<?= e(admin_url('contacts')) ?>">Contact Leads</a><?php endif; ?>
            <?php if (admin_can('view_newsletters')): ?><a href="<?= e(admin_url('newsletters')) ?>">Newsletter Subscribers</a><?php endif; ?>
            <?php if (admin_can('manage_settings')): ?><a href="<?= e(admin_url('settings')) ?>">Frontend Sections</a><?php endif; ?>
            <?php if (admin_can('manage_admins')): ?><a href="<?= e(admin_url('admins')) ?>">Admins</a><?php endif; ?>
        </nav>
    </aside>
    <div class="admin-main">
        <header class="admin-topbar">
            <div>
                <strong><?= e($metaTitle ?? 'Dashboard') ?></strong>
                <p><?= e($user['name'] ?? '') ?> / <?= e($user['role_name'] ?? '') ?></p>
            </div>
            <form method="post" action="<?= e(admin_url('logout')) ?>">
                <?= csrf_field() ?>
                <button class="ghost-button" type="submit">Sign Out</button>
            </form>
        </header>
        <?php if ($flashMessage): ?>
            <div class="flash flash-<?= e($flashMessage['type']) ?>"><?= e($flashMessage['message']) ?></div>
        <?php endif; ?>
        <section class="admin-content">
            <?= $content ?>
        </section>
    </div>
</div>
</body>
</html>
