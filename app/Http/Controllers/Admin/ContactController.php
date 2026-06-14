<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Core\Controller;
use App\Repositories\ContactRepository;

class ContactController extends Controller
{
    public function index(): void
    {
        $this->view('admin/contacts/index', [
            'items' => (new ContactRepository($this->db))->all(),
            'metaTitle' => 'Contact Submissions',
        ], 'layouts/admin');
    }
}
