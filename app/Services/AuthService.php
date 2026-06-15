<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class AuthService
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function attempt(string $username, string $password): bool
    {
        $admin = $this->db->query(
            'SELECT a.*, r.slug AS role_slug, r.name AS role_name
             FROM admins a
             LEFT JOIN roles r ON r.id = a.role_id
             WHERE a.username = :username AND a.is_active = 1
             LIMIT 1',
            ['username' => $username]
        )->fetch();

        if (!$admin) {
            return false;
        }

        $passwordHash = (string) $admin['password_hash'];
        $valid = str_starts_with($passwordHash, 'plain:')
            ? hash_equals(substr($passwordHash, 6), $password)
            : password_verify($password, $passwordHash);

        if (!$valid) {
            return false;
        }

        try {
            $this->db->query('UPDATE admins SET last_login_at = NOW(), last_login_ip = :ip WHERE id = :id', [
                'id' => $admin['id'],
                'ip' => $_SERVER['REMOTE_ADDR'] ?? null,
            ]);
        } catch (\Throwable $exception) {
            // The login must still work if the optional audit columns are not imported yet.
        }

        $permissions = $admin['role_slug'] === 'super-admin'
            ? ['*']
            : array_column($this->db->query(
                'SELECT p.slug
                 FROM role_permissions rp
                 INNER JOIN permissions p ON p.id = rp.permission_id
                 WHERE rp.role_id = :role_id
                 ORDER BY p.slug ASC',
                ['role_id' => $admin['role_id']]
            )->fetchAll(), 'slug');

        $_SESSION['admin'] = [
            'id' => (int) $admin['id'],
            'username' => $admin['username'],
            'name' => $admin['name'],
            'role_id' => (int) $admin['role_id'],
            'role_slug' => $admin['role_slug'],
            'role_name' => $admin['role_name'],
            'permissions' => $permissions,
        ];

        return true;
    }

    public function logout(): void
    {
        unset($_SESSION['admin']);
    }

    public function user(): ?array
    {
        return $_SESSION['admin'] ?? null;
    }

    public function check(): bool
    {
        return !empty($_SESSION['admin']);
    }

    public function can(string $permission): bool
    {
        $user = $this->user();
        if (!$user) {
            return false;
        }

        if ($user['role_slug'] === 'super-admin') {
            return true;
        }

        if (isset($user['permissions']) && is_array($user['permissions'])) {
            return in_array($permission, $user['permissions'], true);
        }

        $row = $this->db->query(
            'SELECT COUNT(*) AS total
             FROM role_permissions rp
             INNER JOIN permissions p ON p.id = rp.permission_id
             WHERE rp.role_id = :role_id AND p.slug = :permission',
            ['role_id' => $user['role_id'], 'permission' => $permission]
        )->fetch();

        return (int) ($row['total'] ?? 0) > 0;
    }
}
