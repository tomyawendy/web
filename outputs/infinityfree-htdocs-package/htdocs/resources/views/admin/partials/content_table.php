<table class="admin-table">
    <thead><tr><th>Title</th><th>Slug</th><th>Template</th><th>Status</th><th>Sort</th><th>Updated</th><th></th></tr></thead>
    <tbody>
    <?php if (empty($items)): ?>
        <tr>
            <td colspan="7">No content pages yet.</td>
        </tr>
    <?php endif; ?>
    <?php foreach ($items as $item): ?>
        <?php $status = (string) ($item['status'] ?? 'draft'); ?>
        <tr>
            <td>
                <strong><?= e($item['title'] ?? $item['slug'] ?? ('#' . $item['id'])) ?></strong>
                <?php if (!empty($item['seo_image'])): ?>
                    <span class="table-muted">SEO image linked</span>
                <?php endif; ?>
            </td>
            <td><code><?= e((string) ($item['slug'] ?? $item['link'] ?? '-')) ?></code></td>
            <td><span class="table-badge"><?= e((string) ($item['template'] ?? 'default')) ?></span></td>
            <td><span class="status-badge status-badge-<?= e($status) ?>"><?= e(ucfirst($status)) ?></span></td>
            <td><?= e((string) ($item['sort_order'] ?? 0)) ?></td>
            <td><?= e(format_datetime($item['updated_at'] ?? null)) ?></td>
            <td><a href="<?= e(admin_url(($editBase ?? 'pages') . '/' . $item['id'])) ?>">Edit</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
