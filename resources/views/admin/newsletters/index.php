<div class="panel admin-section">
    <div class="toolbar">
        <div class="toolbar-copy">
            <span class="tiny-label">Subscriptions</span>
            <h2>Newsletter Subscribers</h2>
            <p>Track opt-ins from the newsletter block, export the list, and mark subscribers as active or unsubscribed.</p>
        </div>
        <a class="button-primary" href="<?= e(admin_url('newsletters/export')) ?>">Export CSV</a>
    </div>
</div>
<div class="panel admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>Email</th><th>Locale</th><th>Source Page</th><th>Status</th><th>Subscribed</th><th>Action</th></tr></thead>
        <tbody>
        <?php if (empty($items)): ?>
            <tr>
                <td colspan="6">No newsletter subscribers yet.</td>
            </tr>
        <?php endif; ?>
        <?php foreach ($items as $item): ?>
            <?php $isActive = (int) ($item['is_active'] ?? 1) === 1; ?>
            <tr>
                <td><a href="mailto:<?= e($item['email']) ?>"><?= e($item['email']) ?></a></td>
                <td><span class="table-badge"><?= e(locale_label((string) $item['locale'])) ?></span></td>
                <td><code><?= e((string) ($item['source_path'] ?: '/')) ?></code></td>
                <td><span class="status-badge <?= $isActive ? 'status-badge-published' : 'status-badge-archived' ?>"><?= $isActive ? 'Active' : 'Unsubscribed' ?></span></td>
                <td><?= e(format_datetime($item['created_at'])) ?></td>
                <td>
                    <form method="post" action="<?= e(admin_url('newsletters/status')) ?>">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= e((string) $item['id']) ?>">
                        <input type="hidden" name="is_active" value="<?= $isActive ? '0' : '1' ?>">
                        <button class="button-secondary compact-button" type="submit"><?= $isActive ? 'Unsubscribe' : 'Activate' ?></button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
