<div class="stats-grid">
    <article><strong><?= e((string) $stats['pages']) ?></strong><span>Content Pages</span></article>
    <article><strong><?= e((string) $stats['services']) ?></strong><span>Service Cards</span></article>
    <article><strong><?= e((string) $stats['posts']) ?></strong><span>Insights + Documents</span></article>
    <article><strong><?= e((string) $stats['contacts']) ?></strong><span>Contact Leads</span></article>
    <article><strong><?= e((string) $stats['newsletter_subscribers']) ?></strong><span>Newsletter Subscribers</span></article>
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
