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

    protected function columnExists(string $table, string $column): bool
    {
        static $cache = [];
        $key = $table . '.' . $column;
        if (array_key_exists($key, $cache)) {
            return $cache[$key];
        }

        try {
            $row = $this->fetchOne("SHOW COLUMNS FROM {$table} LIKE :column", ['column' => $column]);
            $cache[$key] = $row !== null;
        } catch (\Throwable $exception) {
            $cache[$key] = false;
        }

        return $cache[$key];
    }
}
