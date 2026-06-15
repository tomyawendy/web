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

    public function edit(string $id): void
    {
        $repo = new AdminRepository($this->db);
        $item = $repo->find((int) $id);
        if (!$item) {
            redirect_with_flash(admin_url('admins'), 'error', account_not_found_message());
        }

        $this->view('admin/admins/form', [
            'item' => $item,
            'roles' => $repo->roles(),
            'metaTitle' => 'Edit Administrator',
        ], 'layouts/admin');
    }

    public function save(): void
    {
        if (!verify_csrf($this->request->input('_csrf'))) {
            redirect_with_flash(admin_url('admins'), 'error', session_expired_message());
        }

        $password = (string) $this->request->input('password');
        $id = (int) $this->request->input('id', 0);
        if ($id === 0 && $password === '') {
            redirect_with_flash(admin_url('admins/create'), 'error', password_required_message());
        }

        $payload = [
            'id' => $id,
            'role_id' => (int) $this->request->input('role_id'),
            'username' => trim((string) $this->request->input('username')),
            'name' => trim((string) $this->request->input('name')),
            'email' => trim((string) $this->request->input('email')),
            'is_active' => $this->request->input('is_active') ? 1 : 0,
        ];
        if ($password !== '') {
            $payload['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        }

        try {
            $repo = new AdminRepository($this->db);
            if ($id > 0) {
                $repo->update($payload);
            } else {
                $payload['password_hash'] = $payload['password_hash'] ?? password_hash($password, PASSWORD_DEFAULT);
                unset($payload['id']);
                $id = $repo->create($payload);
            }
        } catch (PDOException $exception) {
            $message = is_duplicate_key_error($exception)
                ? 'This username is already in use.'
                : 'We could not save the administrator account. Please try again.';
            redirect_with_flash($id > 0 ? admin_url('admins/' . $id) : admin_url('admins/create'), 'error', $message);
        }

        (new ActivityLogService($this->db))->log($_SESSION['admin']['id'] ?? null, $this->request->input('id') ? 'update' : 'create', 'admins', $id, 'Saved administrator account');
        redirect_with_flash(admin_url('admins'), 'success', 'Administrator saved successfully.');
    }
}
