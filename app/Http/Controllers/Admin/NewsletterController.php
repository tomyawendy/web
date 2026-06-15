<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Core\Controller;
use App\Repositories\NewsletterRepository;
use App\Services\ActivityLogService;

class NewsletterController extends Controller
{
    public function index(): void
    {
        $this->view('admin/newsletters/index', [
            'items' => (new NewsletterRepository($this->db))->all(),
            'metaTitle' => 'Newsletter Subscribers',
        ], 'layouts/admin');
    }

    public function export(): void
    {
        $items = (new NewsletterRepository($this->db))->all();
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="newsletter-subscribers.csv"');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['email', 'locale', 'source_path', 'is_active', 'created_at', 'unsubscribed_at']);
        foreach ($items as $item) {
            fputcsv($output, [
                $item['email'] ?? '',
                $item['locale'] ?? '',
                $item['source_path'] ?? '',
                (string) ($item['is_active'] ?? 1),
                $item['created_at'] ?? '',
                $item['unsubscribed_at'] ?? '',
            ]);
        }
        exit;
    }

    public function status(): void
    {
        if (!verify_csrf($this->request->input('_csrf'))) {
            redirect_with_flash(admin_url('newsletters'), 'error', session_expired_message());
        }

        $id = (int) $this->request->input('id', 0);
        $isActive = (int) $this->request->input('is_active', 0);
        if ($id <= 0) {
            redirect_with_flash(admin_url('newsletters'), 'error', 'Please choose a valid subscriber.');
        }

        (new NewsletterRepository($this->db))->updateStatus($id, $isActive ? 1 : 0);
        (new ActivityLogService($this->db))->log($_SESSION['admin']['id'] ?? null, 'update_status', 'newsletter_subscriptions', $id, $isActive ? 'Activated subscriber' : 'Unsubscribed contact');
        redirect_with_flash(admin_url('newsletters'), 'success', 'Subscriber status updated successfully.');
    }
}
