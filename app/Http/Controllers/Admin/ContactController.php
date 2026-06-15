<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Core\Controller;
use App\Repositories\ContactRepository;
use App\Services\ActivityLogService;

class ContactController extends Controller
{
    public function index(): void
    {
        $this->view('admin/contacts/index', [
            'items' => (new ContactRepository($this->db))->all(),
            'metaTitle' => 'Contact Submissions',
        ], 'layouts/admin');
    }

    public function status(): void
    {
        if (!verify_csrf($this->request->input('_csrf'))) {
            redirect_with_flash(admin_url('contacts'), 'error', session_expired_message());
        }

        $id = (int) $this->request->input('id', 0);
        $status = (string) $this->request->input('status', 'new');
        $allowed = ['new', 'in_progress', 'done'];
        if ($id <= 0 || !in_array($status, $allowed, true)) {
            redirect_with_flash(admin_url('contacts'), 'error', 'Please choose a valid lead and status.');
        }

        (new ContactRepository($this->db))->updateStatus($id, $status, trim((string) $this->request->input('admin_note', '')));
        (new ActivityLogService($this->db))->log($_SESSION['admin']['id'] ?? null, 'update_status', 'contact_submissions', $id, 'Changed lead status to ' . $status);
        redirect_with_flash(admin_url('contacts'), 'success', 'Lead status updated successfully.');
    }

    public function export(): void
    {
        $items = (new ContactRepository($this->db))->all();
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="contact-leads.csv"');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['name', 'company', 'email', 'phone', 'locale', 'subject', 'message', 'status', 'admin_note', 'created_at']);
        foreach ($items as $item) {
            fputcsv($output, [
                $item['name'] ?? '',
                $item['company'] ?? '',
                $item['email'] ?? '',
                $item['phone'] ?? '',
                $item['locale'] ?? '',
                $item['subject'] ?? '',
                $item['message'] ?? '',
                $item['status'] ?? 'new',
                $item['admin_note'] ?? '',
                $item['created_at'] ?? '',
            ]);
        }
        exit;
    }
}
