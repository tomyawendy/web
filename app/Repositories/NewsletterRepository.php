<?php

declare(strict_types=1);

namespace App\Repositories;

class NewsletterRepository extends BaseRepository
{
    public function create(array $payload): int
    {
        $this->execute(
            'INSERT INTO newsletter_subscriptions (email, locale, source_path, created_at)
             VALUES (:email, :locale, :source_path, NOW())',
            $payload
        );

        return $this->lastInsertId();
    }

    public function all(): array
    {
        return $this->fetchAll('SELECT * FROM newsletter_subscriptions ORDER BY id DESC');
    }
}
