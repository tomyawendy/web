<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;

abstract class BaseRepository
{
    protected Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    protected function fetchAll(string $sql, array $params = []): array
    {
        return $this->db->query($sql, $params)->fetchAll();
    }

    protected function fetchOne(string $sql, array $params = []): ?array
    {
        $row = $this->db->query($sql, $params)->fetch();
        return $row ?: null;
    }

    protected function execute(string $sql, array $params = []): void
    {
        $this->db->query($sql, $params);
    }

    protected function lastInsertId(): int
    {
        return (int) $this->db->pdo()->lastInsertId();
    }
}
