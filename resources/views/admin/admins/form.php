<?php $item = $item ?? null; ?>
<form class="admin-form panel" method="post" action="<?= e(admin_url('admins/save')) ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= e((string) ($item['id'] ?? '')) ?>">
    <h2><?= $item ? 'Edit Administrator' : 'Create Administrator' ?></h2>
    <p>Give the account a clear name, the login username, and the exact role it should inherit inside the CMS.</p>
    <div class="button-row">
        <label>Name<input name="name" value="<?= e((string) ($item['name'] ?? '')) ?>" required></label>
        <label>Username<input name="username" value="<?= e((string) ($item['username'] ?? '')) ?>" required></label>
    </div>
    <div class="button-row">
        <label>Email<input name="email" value="<?= e((string) ($item['email'] ?? '')) ?>"></label>
        <label>Password
            <input type="password" name="password" <?= $item ? '' : 'required' ?>>
            <span class="field-note"><?= $item ? 'Leave blank to keep the current password.' : 'Required for new accounts.' ?></span>
        </label>
    </div>
    <div class="button-row">
        <label>Role
            <select name="role_id">
                <?php foreach ($roles as $role): ?>
                    <option value="<?= e((string) $role['id']) ?>" <?= (int) ($item['role_id'] ?? 0) === (int) $role['id'] ? 'selected' : '' ?>><?= e($role['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label class="checkbox-line"><input type="checkbox" name="is_active" value="1" <?= !isset($item) || !empty($item['is_active']) ? 'checked' : '' ?>> Active</label>
    </div>
    <button class="button-primary" type="submit"><?= $item ? 'Save Administrator' : 'Create' ?></button>
</form>
