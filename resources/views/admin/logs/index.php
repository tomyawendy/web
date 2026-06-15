<div class="panel admin-section">
    <div class="toolbar">
        <div class="toolbar-copy">
            <span class="tiny-label">Audit trail</span>
            <h2>Operation Logs</h2>
            <p>Review recent CMS actions such as saves, uploads, status changes, and admin operations.</p>
        </div>
    </div>
    <form class="admin-filter-form" method="get" action="<?= e(admin_url('logs')) ?>">
        <label>Search
            <input name="q" value="<?= e((string) ($filters['q'] ?? '')) ?>" placeholder="Admin, action, or summary">
        </label>
        <label>Module
            <input name="module" value="<?= e((string) ($filters['module'] ?? '')) ?>" placeholder="posts, media, contacts">
        </label>
        <button class="button-secondary" type="submit">Filter</button>
        <a class="button-secondary" href="<?= e(admin_url('logs')) ?>">Reset</a>
    </form>
</div>
<div class="panel admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>Time</th><th>Admin</th><th>Module</th><th>Action</th><th>Entity</th><th>IP</th><th>Summary</th></tr></thead>
        <tbody>
        <?php if (empty($items)): ?>
            <tr>
                <td colspan="7">No operation logs found.</td>
            </tr>
        <?php endif; ?>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= e(format_datetime($item['created_at'])) ?></td>
                <td><?= e((string) ($item['username'] ?: '-')) ?></td>
                <td><span class="table-badge"><?= e($item['module']) ?></span></td>
                <td><?= e($item['action']) ?></td>
                <td><?= e((string) ($item['entity_id'] ?? '-')) ?></td>
                <td><?= e((string) ($item['ip_address'] ?? '-')) ?></td>
                <td><?= e((string) ($item['summary'] ?? '')) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
