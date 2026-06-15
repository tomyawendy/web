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

    public function findByEmail(string $email): ?array
    {
        return $this->fetchOne('SELECT * FROM newsletter_subscriptions WHERE email = :email', ['email' => $email]);
    }

    public function reactivate(string $email, string $locale, string $sourcePath): void
    {
        $this->execute(
            'UPDATE newsletter_subscriptions SET is_active = 1, unsubscribed_at = NULL, locale = :locale, source_path = :source_path WHERE email = :email',
            ['email' => $email, 'locale' => $locale, 'source_path' => $sourcePath]
        );
    }

    public function updateStatus(int $id, int $isActive): void
    {
        $this->execute(
            'UPDATE newsletter_subscriptions SET is_active = :is_active, unsubscribed_at = :unsubscribed_at WHERE id = :id',
            ['id' => $id, 'is_active' => $isActive, 'unsubscribed_at' => $isActive ? null : date('Y-m-d H:i:s')]
        );
    }
}
