<?php

declare(strict_types=1);

namespace App\Repositories;

class MediaRepository extends BaseRepository
{
    public function all(): array
    {
        return $this->fetchAll('SELECT * FROM media ORDER BY id DESC');
    }

    public function create(array $media): int
    {
        $this->execute(
            'INSERT INTO media (file_name, file_path, file_type, mime_type, file_size, created_at)
             VALUES (:file_name, :file_path, :file_type, :mime_type, :file_size, NOW())',
            $media
        );

        return $this->lastInsertId();
    }
}
