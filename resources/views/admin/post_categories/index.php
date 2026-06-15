<?php $item = $item ?? null; ?>
<div class="panel admin-section">
    <div class="toolbar">
        <div class="toolbar-copy">
            <span class="tiny-label">Categories</span>
            <h2>Content Categories</h2>
            <p>Manage categories used by Insights and Documents. Keep the list short and clear for easier filtering.</p>
        </div>
        <div class="button-row">
            <a class="button-secondary <?= $type === 'news' ? 'active' : '' ?>" href="<?= e(admin_url('post-categories?type=news')) ?>">Insights</a>
            <a class="button-secondary <?= $type === 'document' ? 'active' : '' ?>" href="<?= e(admin_url('post-categories?type=document')) ?>">Documents</a>
        </div>
    </div>
</div>

<form class="admin-form panel" method="post" action="<?= e(admin_url('post-categories/save')) ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= e((string) ($item['id'] ?? '')) ?>">
    <input type="hidden" name="type" value="<?= e($type) ?>">
    <h2><?= $item ? 'Edit Category' : 'Create Category' ?></h2>
    <div class="button-row">
        <label>Name<input name="name" value="<?= e((string) ($item['name'] ?? '')) ?>" required></label>
        <label>Sort Order<input name="sort_order" type="number" value="<?= e((string) ($item['sort_order'] ?? 0)) ?>"></label>
    </div>
    <button class="button-primary" type="submit"><?= $item ? 'Save Category' : 'Create Category' ?></button>
</form>

<div class="panel admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>Name</th><th>Type</th><th>Sort Order</th><th></th></tr></thead>
        <tbody>
        <?php if (empty($items)): ?>
            <tr>
                <td colspan="4">No categories found.</td>
            </tr>
        <?php endif; ?>
        <?php foreach ($items as $category): ?>
            <tr>
                <td><strong><?= e($category['name']) ?></strong></td>
                <td><span class="table-badge"><?= e($category['type']) ?></span></td>
                <td><?= e((string) $category['sort_order']) ?></td>
                <td><a href="<?= e(admin_url('post-categories/' . $category['id'])) ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
