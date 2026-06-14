<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Core\Controller;
use App\Repositories\DashboardRepository;
use App\Services\AuthService;

class DashboardController extends Controller
{
    public function index(): void
    {
        $repo = new DashboardRepository($this->db);
        $this->view('admin/dashboard/index', [
            'stats' => $repo->stats(),
            'logs' => $repo->recentLogs(),
            'user' => (new AuthService($this->db))->user(),
            'metaTitle' => 'Dashboard',
        ], 'layouts/admin');
    }
}
