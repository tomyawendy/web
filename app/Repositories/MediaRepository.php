<?php

declare(strict_types=1);

namespace App\Repositories;

class MediaRepository extends BaseRepository
{
    public function find(int $id): ?array
    {
        $media = $this->fetchOne('SELECT * FROM media WHERE id = :id', ['id' => $id]);

        return $media ?: null;
    }

    public function all(array $filters = []): array
    {
        $where = 'WHERE 1 = 1';
        $params = [];

        if (!empty($filters['type'])) {
            $where .= ' AND file_type = :type';
            $params['type'] = (string) $filters['type'];
        }

        if (!empty($filters['q'])) {
            $where .= ' AND (file_name LIKE :q OR file_path LIKE :q OR mime_type LIKE :q)';
            $params['q'] = '%' . trim((string) $filters['q']) . '%';
        }

        return $this->fetchAll("SELECT * FROM media {$where} ORDER BY id DESC", $params);
    }

    public function create(array $media): int
    {
        if (!$this->columnExists('media', 'alt_text')) {
            unset($media['alt_text']);
            $this->execute(
                'INSERT INTO media (file_name, file_path, file_type, mime_type, file_size, created_at)
                 VALUES (:file_name, :file_path, :file_type, :mime_type, :file_size, NOW())',
                $media
            );

            return $this->lastInsertId();
        }

        $this->execute(
            'INSERT INTO media (file_name, file_path, file_type, mime_type, file_size, alt_text, created_at)
             VALUES (:file_name, :file_path, :file_type, :mime_type, :file_size, :alt_text, NOW())',
            $media
        );

        return $this->lastInsertId();
    }

    public function delete(int $id): void
    {
        $this->execute('DELETE FROM media WHERE id = :id', ['id' => $id]);
    }
}
