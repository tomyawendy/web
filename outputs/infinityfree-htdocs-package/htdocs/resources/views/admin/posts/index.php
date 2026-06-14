<div class="panel admin-section">
    <div class="toolbar">
        <div class="toolbar-copy">
            <span class="tiny-label"><?= $type === 'news' ? 'Insights' : 'Documents' ?></span>
            <h2><?= $type === 'news' ? 'Insights' : 'Documents' ?></h2>
            <p><?= $type === 'news' ? 'Use insights for news posts and announcements that appear on the homepage and listing page.' : 'Use documents for official files with attachments and download links.' ?></p>
        </div>
        <div class="button-row">
            <a class="button-secondary <?= $type === 'news' ? 'active' : '' ?>" href="<?= e(admin_url('posts?type=news')) ?>">Insights</a>
            <a class="button-secondary <?= $type === 'document' ? 'active' : '' ?>" href="<?= e(admin_url('posts?type=document')) ?>">Documents</a>
            <a class="button-primary" href="<?= e(admin_url('posts/create?type=' . $type)) ?>"><?= $type === 'news' ? 'Create Insight' : 'Create Document' ?></a>
        </div>
    </div>
</div>
<div class="panel admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>Title</th><th>Category</th><th>Status</th><th>Pinned</th><th>Featured</th><th>Attachment</th><th>Published</th><th>Updated</th><th></th></tr></thead>
        <tbody>
        <?php if (empty($items)): ?>
            <tr>
                <td colspan="9">No items found for this content type.</td>
            </tr>
        <?php endif; ?>
        <?php foreach ($items as $item): ?>
            <?php $status = (string) ($item['status'] ?? 'draft'); ?>
            <tr>
                <td>
                    <strong><?= e($item['title']) ?></strong>
                    <?php if (!empty($item['excerpt'])): ?>
                        <span class="table-muted"><?= e((string) $item['excerpt']) ?></span>
                    <?php endif; ?>
                </td>
                <td><span class="table-badge"><?= e((string) ($item['category_name'] ?? '-')) ?></span></td>
                <td><span class="status-badge status-badge-<?= e($status) ?>"><?= e(ucfirst($status)) ?></span></td>
                <td><?= $item['is_pinned'] ? 'Pinned' : '—' ?></td>
                <td><?= $item['is_featured'] ? 'Featured' : '—' ?></td>
                <td>
                    <?php if (!empty($item['attachment_name']) && !empty($item['attachment_path'])): ?>
                        <a href="<?= e(media_url((string) $item['attachment_path'])) ?>" target="_blank"><?= e($item['attachment_name']) ?></a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td><?= e(format_datetime($item['published_at'])) ?></td>
                <td><?= e(format_datetime($item['updated_at'] ?? null)) ?></td>
                <td><a href="<?= e(admin_url('posts/' . $item['id'])) ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
