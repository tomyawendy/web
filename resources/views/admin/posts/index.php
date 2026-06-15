<div class="panel admin-section">
    <div class="toolbar">
        <div class="toolbar-copy">
            <span class="tiny-label"><?= $type === 'news' ? 'Insights' : 'Documents' ?></span>
            <h2><?= $type === 'news' ? 'Insights' : 'Documents' ?></h2>
            <p><?= $type === 'news' ? 'Use insights for news posts that appear on the homepage and listing page.' : 'Use documents for official files with attachments and download links.' ?></p>
        </div>
        <div class="button-row">
            <a class="button-secondary <?= $type === 'news' ? 'active' : '' ?>" href="<?= e(admin_url('posts?type=news')) ?>">Insights</a>
            <a class="button-secondary <?= $type === 'document' ? 'active' : '' ?>" href="<?= e(admin_url('posts?type=document')) ?>">Documents</a>
            <a class="button-secondary" href="<?= e(admin_url('post-categories?type=' . $type)) ?>">Manage Categories</a>
            <a class="button-primary" href="<?= e(admin_url('posts/create?type=' . $type)) ?>"><?= $type === 'news' ? 'Create Insight' : 'Create Document' ?></a>
        </div>
    </div>

    <form class="admin-filter-form" method="get" action="<?= e(admin_url('posts')) ?>">
        <input type="hidden" name="type" value="<?= e($type) ?>">
        <label>Search
            <input name="q" value="<?= e((string) ($filters['q'] ?? '')) ?>" placeholder="Title, summary, or slug">
        </label>
        <label>Status
            <select name="status">
                <option value="">All statuses</option>
                <?php foreach (status_options() as $value => $label): ?>
                    <option value="<?= e($value) ?>" <?= ($filters['status'] ?? '') === $value ? 'selected' : '' ?>><?= e($label) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Category
            <select name="category_id">
                <option value="">All categories</option>
                <?php foreach (($categories ?? []) as $category): ?>
                    <option value="<?= e((string) $category['id']) ?>" <?= (int) ($filters['category_id'] ?? 0) === (int) $category['id'] ? 'selected' : '' ?>><?= e($category['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <button class="button-secondary" type="submit">Filter</button>
        <a class="button-secondary" href="<?= e(admin_url('posts?type=' . $type)) ?>">Reset</a>
    </form>
</div>

<form class="panel admin-table-wrap" method="post" action="<?= e(admin_url('posts/bulk')) ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="type" value="<?= e($type) ?>">
    <div class="bulk-bar">
        <strong><?= count($items) ?> item(s)</strong>
        <label>Bulk action
            <select name="bulk_action">
                <option value="status">Change status</option>
                <option value="delete">Delete selected</option>
            </select>
        </label>
        <label>Bulk status
            <select name="bulk_status">
                <option value="">Choose status</option>
                <?php foreach (status_options() as $value => $label): ?>
                    <option value="<?= e($value) ?>"><?= e($label) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <button class="button-secondary" type="submit" onclick="return this.form.bulk_action.value !== 'delete' || confirm('Delete selected items? This removes the content records and translations. Uploaded files are kept in Media Library.');">Apply to selected</button>
    </div>
    <table class="admin-table">
        <thead>
        <tr>
            <th>Select</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Pinned</th>
            <th>Featured</th>
            <th>Attachment</th>
            <th>Published</th>
            <th>Updated</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($items)): ?>
            <tr>
                <td colspan="10">No items found for this content type.</td>
            </tr>
        <?php endif; ?>
        <?php foreach ($items as $item): ?>
            <?php $status = (string) ($item['status'] ?? 'draft'); ?>
            <tr>
                <td><input type="checkbox" name="ids[]" value="<?= e((string) $item['id']) ?>" aria-label="Select <?= e((string) $item['title']) ?>"></td>
                <td>
                    <strong><?= e((string) $item['title']) ?></strong>
                    <span class="table-muted"><?= e((string) ($item['slug'] ?? '')) ?></span>
                    <?php if (!empty($item['excerpt'])): ?>
                        <span class="table-muted"><?= e((string) $item['excerpt']) ?></span>
                    <?php endif; ?>
                </td>
                <td><span class="table-badge"><?= e((string) ($item['category_name'] ?? '-')) ?></span></td>
                <td><span class="status-badge status-badge-<?= e($status) ?>"><?= e(ucfirst($status)) ?></span></td>
                <td><?= $item['is_pinned'] ? 'Pinned' : '-' ?></td>
                <td><?= $item['is_featured'] ? 'Featured' : '-' ?></td>
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
</form>
