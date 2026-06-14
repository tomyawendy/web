<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class ActivityLogService
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function log(?int $adminId, string $action, string $module, ?int $entityId = null, ?string $summary = null): void
    {
        $this->db->query(
            'INSERT INTO operation_logs (admin_id, action, module, entity_id, summary, ip_address, created_at)
             VALUES (:admin_id, :action, :module, :entity_id, :summary, :ip_address, NOW())',
            [
                'admin_id' => $adminId,
                'action' => $action,
                'module' => $module,
                'entity_id' => $entityId,
                'summary' => $summary,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
            ]
        );
    }
}
