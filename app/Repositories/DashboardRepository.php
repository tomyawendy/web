<?php

declare(strict_types=1);

namespace App\Repositories;

class DashboardRepository extends BaseRepository
{
    public function stats(): array
    {
        return [
            'pages' => (int) ($this->fetchOne('SELECT COUNT(*) AS total FROM pages')['total'] ?? 0),
            'services' => (int) ($this->fetchOne('SELECT COUNT(*) AS total FROM services')['total'] ?? 0),
            'posts' => (int) ($this->fetchOne('SELECT COUNT(*) AS total FROM posts')['total'] ?? 0),
            'contacts' => (int) ($this->fetchOne('SELECT COUNT(*) AS total FROM contact_submissions')['total'] ?? 0),
            'newsletter_subscribers' => (int) ($this->fetchOne('SELECT COUNT(*) AS total FROM newsletter_subscriptions')['total'] ?? 0),
        ];
    }

    public function recentLogs(): array
    {
        return $this->fetchAll(
            'SELECT l.*, a.username
             FROM operation_logs l
             LEFT JOIN admins a ON a.id = l.admin_id
             ORDER BY l.id DESC
             LIMIT 12'
        );
    }

    public function logs(array $filters = []): array
    {
        $where = 'WHERE 1 = 1';
        $params = [];

        if (!empty($filters['module'])) {
            $where .= ' AND l.module = :module';
            $params['module'] = (string) $filters['module'];
        }

        if (!empty($filters['q'])) {
            $where .= ' AND (l.action LIKE :q OR l.summary LIKE :q OR a.username LIKE :q)';
            $params['q'] = '%' . trim((string) $filters['q']) . '%';
        }

        return $this->fetchAll(
            "SELECT l.*, a.username
             FROM operation_logs l
             LEFT JOIN admins a ON a.id = l.admin_id
             {$where}
             ORDER BY l.id DESC
             LIMIT 200",
            $params
        );
    }
}
