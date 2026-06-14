<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Core\Controller;
use App\Repositories\NewsletterRepository;

class NewsletterController extends Controller
{
    public function index(): void
    {
        $this->view('admin/newsletters/index', [
            'items' => (new NewsletterRepository($this->db))->all(),
            'metaTitle' => 'Newsletter Subscribers',
        ], 'layouts/admin');
    }
}
