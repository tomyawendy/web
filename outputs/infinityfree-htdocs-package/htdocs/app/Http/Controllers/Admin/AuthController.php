<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Core\Controller;
use App\Services\ActivityLogService;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function showLogin(): void
    {
        $this->view('admin/auth/login', ['metaTitle' => 'Admin Login'], 'layouts/admin_auth');
    }

    public function login(): void
    {
        if (!verify_csrf($this->request->input('_csrf'))) {
            redirect_with_flash(admin_url('login'), 'error', session_expired_message());
        }

        $auth = new AuthService($this->db);
        if (!$auth->attempt((string) $this->request->input('username'), (string) $this->request->input('password'))) {
            redirect_with_flash(admin_url('login'), 'error', invalid_credentials_message());
        }

        $user = $auth->user();
        (new ActivityLogService($this->db))->log($user['id'], 'login', 'auth', $user['id'], 'Administrator signed in');
        $this->redirect(admin_url());
    }

    public function logout(): void
    {
        if (!verify_csrf($this->request->input('_csrf'))) {
            redirect_with_flash(admin_url(), 'error', session_expired_message());
        }

        $auth = new AuthService($this->db);
        $user = $auth->user();
        if ($user) {
            (new ActivityLogService($this->db))->log($user['id'], 'logout', 'auth', $user['id'], 'Administrator signed out');
        }
        $auth->logout();
        redirect_with_flash(admin_url('login'), 'success', 'You have signed out successfully.');
    }

    public function changePassword(): void
    {
        if (!verify_csrf($this->request->input('_csrf'))) {
            redirect_with_flash(admin_url(), 'error', session_expired_message());
        }

        $user = admin_user();
        $current = (string) $this->request->input('current_password');
        $new = (string) $this->request->input('new_password');
        $confirm = (string) $this->request->input('new_password_confirmation');

        if (!$user || $new === '' || $new !== $confirm) {
            redirect_with_flash(admin_url(), 'error', password_confirmation_message());
        }

        $admin = $this->db->query('SELECT * FROM admins WHERE id = :id', ['id' => $user['id']])->fetch();
        if (!$admin) {
            redirect_with_flash(admin_url(), 'error', account_not_found_message());
        }

        $passwordHash = (string) $admin['password_hash'];
        $valid = str_starts_with($passwordHash, 'plain:')
            ? hash_equals(substr($passwordHash, 6), $current)
            : password_verify($current, $passwordHash);

        if (!$valid) {
            redirect_with_flash(admin_url(), 'error', current_password_incorrect_message());
        }

        $this->db->query(
            'UPDATE admins SET password_hash = :password_hash, updated_at = NOW() WHERE id = :id',
            ['password_hash' => password_hash($new, PASSWORD_DEFAULT), 'id' => $user['id']]
        );

        (new ActivityLogService($this->db))->log($user['id'], 'password', 'auth', $user['id'], 'Administrator updated password');
        redirect_with_flash(admin_url(), 'success', 'Password updated successfully.');
    }
}
