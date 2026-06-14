<form class="admin-form panel" method="post" action="<?= e(admin_url('admins/save')) ?>">
    <?= csrf_field() ?>
    <h2>Create Administrator</h2>
    <p>Give the account a clear name, the login username, and the exact role it should inherit inside the CMS.</p>
    <div class="button-row">
        <label>Name<input name="name" required></label>
        <label>Username<input name="username" required></label>
    </div>
    <div class="button-row">
        <label>Email<input name="email"></label>
        <label>Password<input type="password" name="password" required></label>
    </div>
    <div class="button-row">
        <label>Role
            <select name="role_id">
                <?php foreach ($roles as $role): ?>
                    <option value="<?= e((string) $role['id']) ?>"><?= e($role['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label class="checkbox-line"><input type="checkbox" name="is_active" value="1" checked> Active</label>
    </div>
    <button class="button-primary" type="submit">Create</button>
</form>
