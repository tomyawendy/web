<?php

declare(strict_types=1);

namespace App\Repositories;

class PostCategoryRepository extends BaseRepository
{
    public function all(?string $type = null): array
    {
        $where = $type ? 'WHERE type = :type' : '';
        $params = $type ? ['type' => $type] : [];
        return $this->fetchAll("SELECT * FROM post_categories {$where} ORDER BY type ASC, sort_order ASC, id DESC", $params);
    }

    public function find(int $id): ?array
    {
        return $this->fetchOne('SELECT * FROM post_categories WHERE id = :id', ['id' => $id]);
    }

    public function save(array $payload): int
    {
        if (!empty($payload['id'])) {
            $this->execute(
                'UPDATE post_categories SET type = :type, name = :name, sort_order = :sort_order WHERE id = :id',
                $payload
            );
            return (int) $payload['id'];
        }

        $this->execute(
            'INSERT INTO post_categories (type, name, sort_order) VALUES (:type, :name, :sort_order)',
            $payload
        );
        return $this->lastInsertId();
    }
}
