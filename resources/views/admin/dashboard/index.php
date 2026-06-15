<div class="stats-grid">
    <article><strong><?= e((string) $stats['pages']) ?></strong><span>Pages</span></article>
    <article><strong><?= e((string) $stats['services']) ?></strong><span>Services</span></article>
    <article><strong><?= e((string) $stats['posts']) ?></strong><span>Insights + Documents</span></article>
    <article><strong><?= e((string) $stats['contacts']) ?></strong><span>Contact Leads</span></article>
    <article><strong><?= e((string) $stats['newsletter_subscribers']) ?></strong><span>Newsletter Subscribers</span></article>
</div>
<div class="panel admin-section">
    <div class="toolbar-copy">
        <span class="tiny-label">CMS operating rules</span>
        <h2>English default, Spanish frontend available</h2>
        <p>The CMS exposes English and Spanish content fields only. The public site opens in English by default and switches to Spanish manually. Some homepage and stage sections are Figma-locked to protect the approved 1:1 visual.</p>
    </div>
    <div class="cms-rule-grid">
        <article><strong>Editable content</strong><span>Pages, service cards, insights, documents, media, leads, and newsletter records.</span></article>
        <article><strong>Visual lock</strong><span>Do not replace Figma stage assets unless a screenshot comparison pass is planned.</span></article>
        <article><strong>Database patch</strong><span>Import the latest file from database/patches before using new lead status fields.</span></article>
    </div>
</div>
<div class="panel">
    <h2>Recent activity</h2>
    <table class="admin-table">
        <thead><tr><th>Time</th><th>Admin</th><th>Module</th><th>Action</th><th>Summary</th></tr></thead>
        <tbody>
        <?php foreach ($logs as $log): ?>
            <tr>
                <td><?= e(format_datetime($log['created_at'])) ?></td>
                <td><?= e($log['username'] ?: '-') ?></td>
                <td><?= e($log['module']) ?></td>
                <td><?= e($log['action']) ?></td>
                <td><?= e($log['summary']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<form class="admin-form panel" method="post" action="<?= e(admin_url('password')) ?>">
    <?= csrf_field() ?>
    <h2>Change password</h2>
    <label>Current Password<input type="password" name="current_password" required></label>
    <label>New Password<input type="password" name="new_password" required></label>
    <label>Confirm New Password<input type="password" name="new_password_confirmation" required></label>
    <button class="button-primary" type="submit">Update Password</button>
</form>
