<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Core\Controller;
use App\Repositories\DashboardRepository;

class LogController extends Controller
{
    public function index(): void
    {
        $filters = [
            'q' => trim((string) $this->request->query('q', '')),
            'module' => trim((string) $this->request->query('module', '')),
        ];

        $this->view('admin/logs/index', [
            'items' => (new DashboardRepository($this->db))->logs($filters),
            'filters' => $filters,
            'metaTitle' => 'Operation Logs',
        ], 'layouts/admin');
    }
}
