<div class="panel admin-section">
    <div class="toolbar">
        <div class="toolbar-copy">
            <span class="tiny-label">Subscriptions</span>
            <h2>Newsletter Subscribers</h2>
            <p>Track opt-ins from the newsletter block on the public site. This list is useful when the marketing team needs to export or follow up.</p>
        </div>
    </div>
</div>
<div class="panel admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>Email</th><th>Locale</th><th>Source Page</th><th>Subscribed</th></tr></thead>
        <tbody>
        <?php if (empty($items)): ?>
            <tr>
                <td colspan="4">No newsletter subscribers yet.</td>
            </tr>
        <?php endif; ?>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><a href="mailto:<?= e($item['email']) ?>"><?= e($item['email']) ?></a></td>
                <td><span class="table-badge"><?= e(locale_label((string) $item['locale'])) ?></span></td>
                <td><code><?= e((string) ($item['source_path'] ?: '/')) ?></code></td>
                <td><?= e(format_datetime($item['created_at'])) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
