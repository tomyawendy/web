<?php

declare(strict_types=1);

namespace App\Repositories;

class ContactRepository extends BaseRepository
{
    public function create(array $payload): int
    {
        $this->execute(
            'INSERT INTO contact_submissions (name, company, email, phone, subject, message, locale, created_at)
             VALUES (:name, :company, :email, :phone, :subject, :message, :locale, NOW())',
            $payload
        );

        return $this->lastInsertId();
    }

    public function all(): array
    {
        return $this->fetchAll('SELECT * FROM contact_submissions ORDER BY id DESC');
    }

    public function updateStatus(int $id, string $status, string $adminNote): void
    {
        $this->execute(
            'UPDATE contact_submissions SET status = :status, admin_note = :admin_note, updated_at = NOW() WHERE id = :id',
            ['id' => $id, 'status' => $status, 'admin_note' => $adminNote]
        );
    }
}
