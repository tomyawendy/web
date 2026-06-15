<?php

declare(strict_types=1);

namespace App\Repositories;

class AdminRepository extends BaseRepository
{
    public function all(): array
    {
        return $this->fetchAll(
            'SELECT a.*, r.name AS role_name
             FROM admins a
             LEFT JOIN roles r ON r.id = a.role_id
             ORDER BY a.id DESC'
        );
    }

    public function roles(): array
    {
        return $this->fetchAll('SELECT * FROM roles ORDER BY id ASC');
    }

    public function find(int $id): ?array
    {
        return $this->fetchOne('SELECT * FROM admins WHERE id = :id', ['id' => $id]);
    }

    public function create(array $payload): int
    {
        $this->execute(
            'INSERT INTO admins (role_id, username, password_hash, name, email, is_active, created_at, updated_at)
             VALUES (:role_id, :username, :password_hash, :name, :email, :is_active, NOW(), NOW())',
            $payload
        );

        return $this->lastInsertId();
    }

    public function update(array $payload): void
    {
        $sql = 'UPDATE admins SET role_id = :role_id, username = :username, name = :name, email = :email, is_active = :is_active, updated_at = NOW()';
        if (!empty($payload['password_hash'])) {
            $sql .= ', password_hash = :password_hash';
        }
        $sql .= ' WHERE id = :id';

        $this->execute($sql, $payload);
    }
}
