<div class="panel admin-section">
    <div class="toolbar">
        <div class="toolbar-copy">
            <span class="tiny-label">Access</span>
            <h2>Administrators</h2>
            <p>Manage logins, roles, and whether each account is active. This keeps content work and access control in the same place.</p>
        </div>
        <a class="button-primary" href="<?= e(admin_url('admins/create')) ?>">Create Admin</a>
    </div>
</div>
<div class="panel admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>Name</th><th>Username</th><th>Role</th><th>Status</th></tr></thead>
        <tbody>
        <?php if (empty($items)): ?>
            <tr>
                <td colspan="4">No administrator accounts found.</td>
            </tr>
        <?php endif; ?>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= e($item['name']) ?></td>
                <td><code><?= e($item['username']) ?></code></td>
                <td><span class="table-badge"><?= e($item['role_name']) ?></span></td>
                <td><span class="status-badge <?= $item['is_active'] ? 'status-badge-published' : 'status-badge-archived' ?>"><?= $item['is_active'] ? 'Active' : 'Disabled' ?></span></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
