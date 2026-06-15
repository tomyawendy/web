<div class="panel admin-section">
    <div class="toolbar">
        <div class="toolbar-copy">
            <span class="tiny-label">Pages</span>
            <h2>Pages</h2>
            <p>Use these pages for About, Contact and any reusable site sections. Each page can carry its own SEO image and translated copy.</p>
        </div>
        <a class="button-primary" href="<?= e(admin_url('pages/create')) ?>">Create Page</a>
    </div>
</div>
<?php $editBase = 'pages'; ?>
<div class="panel admin-table-wrap">
    <?php include base_path('resources/views/admin/partials/content_table.php'); ?>
</div>
