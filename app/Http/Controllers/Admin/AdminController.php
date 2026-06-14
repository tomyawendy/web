<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Core\Controller;
use App\Repositories\AdminRepository;
use App\Services\ActivityLogService;
use PDOException;

class AdminController extends Controller
{
    public function index(): void
    {
        $repo = new AdminRepository($this->db);
        $this->view('admin/admins/index', [
            'items' => $repo->all(),
            'metaTitle' => 'Administrators',
        ], 'layouts/admin');
    }

    public function create(): void
    {
        $repo = new AdminRepository($this->db);
        $this->view('admin/admins/form', [
            'roles' => $repo->roles(),
            'metaTitle' => 'Create Administrator',
        ], 'layouts/admin');
    }

    public function save(): void
    {
        if (!verify_csrf($this->request->input('_csrf'))) {
            redirect_with_flash(admin_url('admins'), 'error', session_expired_message());
        }

        $password = (string) $this->request->input('password');
        if ($password === '') {
            redirect_with_flash(admin_url('admins/create'), 'error', password_required_message());
        }

        $payload = [
            'role_id' => (int) $this->request->input('role_id'),
            'username' => trim((string) $this->request->input('username')),
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'name' => trim((string) $this->request->input('name')),
            'email' => trim((string) $this->request->input('email')),
            'is_active' => $this->request->input('is_active') ? 1 : 0,
        ];

        try {
            $repo = new AdminRepository($this->db);
            $id = $repo->create($payload);
        } catch (PDOException $exception) {
            $message = is_duplicate_key_error($exception)
                ? 'This username is already in use.'
                : 'We could not save the administrator account. Please try again.';
            redirect_with_flash(admin_url('admins/create'), 'error', $message);
        }

        (new ActivityLogService($this->db))->log($_SESSION['admin']['id'] ?? null, 'create', 'admins', $id, 'Created administrator account');
        redirect_with_flash(admin_url('admins'), 'success', 'Administrator created successfully.');
    }
}
