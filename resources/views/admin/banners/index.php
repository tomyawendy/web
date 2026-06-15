<div class="panel admin-section">
    <div class="toolbar">
        <div class="toolbar-copy">
            <span class="tiny-label">Banners</span>
            <h2>Banners</h2>
            <p>Control the homepage banner headline, supporting copy, CTA, and image. Only one banner is active at a time in the live design.</p>
        </div>
        <a class="button-primary" href="<?= e(admin_url('banners/create')) ?>">Create Banner</a>
    </div>
</div>
<div class="panel admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>Title</th><th>Link</th><th>Status</th><th>Sort</th><th>Updated</th><th></th></tr></thead>
        <tbody>
        <?php if (empty($items)): ?>
            <tr>
                <td colspan="6">No banners found.</td>
            </tr>
        <?php endif; ?>
        <?php foreach ($items as $item): ?>
            <?php $status = (string) ($item['status'] ?? 'draft'); ?>
            <tr>
                <td>
                    <strong><?= e($item['title'] ?? ('#' . $item['id'])) ?></strong>
                    <?php if (!empty($item['image'])): ?>
                        <span class="table-muted">Image linked</span>
                    <?php endif; ?>
                </td>
                <td><code><?= e((string) ($item['link'] ?? '-')) ?></code></td>
                <td><span class="status-badge status-badge-<?= e($status) ?>"><?= e(ucfirst($status)) ?></span></td>
                <td><?= e((string) ($item['sort_order'] ?? 0)) ?></td>
                <td><?= e(format_datetime($item['updated_at'] ?? null)) ?></td>
                <td><a href="<?= e(admin_url('banners/' . $item['id'])) ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
