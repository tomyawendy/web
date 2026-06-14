<?php $flashMessage = flash(); ?>
<div class="login-shell">
    <div class="login-card">
        <p class="eyebrow">Planet Aviation CMS</p>
        <h1>Admin Sign In</h1>
        <p>Use the seeded administrator account first, then create role-specific users.</p>
        <?php if ($flashMessage): ?>
            <div class="flash flash-<?= e($flashMessage['type']) ?>"><?= e($flashMessage['message']) ?></div>
        <?php endif; ?>
        <form method="post" action="<?= e(admin_url('login')) ?>">
            <?= csrf_field() ?>
            <label>Username<input type="text" name="username" required></label>
            <label>Password<input type="password" name="password" required></label>
            <button class="button-primary wide-button" type="submit">Sign In</button>
        </form>
    </div>
</div>
