<?php

declare(strict_types=1);

namespace App\Http\Controllers\PublicSite;

use App\Core\Controller;
use App\Repositories\ContactRepository;
use App\Repositories\SettingRepository;

class ContactController extends Controller
{
    public function submit(): void
    {
        $settings = public_settings_for_display((new SettingRepository($this->db))->allGrouped()[current_locale()] ?? []);
        $returnTo = normalize_return_path((string) $this->request->input('return_to'), '/contact#contact');

        if (!verify_csrf($this->request->input('_csrf'))) {
            redirect_with_flash_data(app_url(ltrim($returnTo, '/')), [
                'type' => 'error',
                'message' => (string) ($settings['contact_error_invalid'] ?? 'Your session expired. Please try again.'),
                'source' => 'contact',
            ]);
        }

        $payload = [
            'name' => trim((string) $this->request->input('name')),
            'company' => trim((string) $this->request->input('company')),
            'email' => trim((string) $this->request->input('email')),
            'phone' => trim((string) $this->request->input('phone')),
            'subject' => trim((string) $this->request->input('subject')) ?: (current_locale() === 'es' ? 'Consulta desde el sitio web de Planet Aviation' : trim(site_name($settings) . ' Website Inquiry')),
            'message' => trim((string) $this->request->input('message')),
            'locale' => current_locale(),
        ];

        with_old($payload);

        if ($payload['name'] === '' || $payload['email'] === '' || $payload['message'] === '') {
            redirect_with_flash_data(app_url(ltrim($returnTo, '/')), [
                'type' => 'error',
                'message' => (string) ($settings['contact_error_required'] ?? 'Name, email, and message are required.'),
                'source' => 'contact',
            ]);
        }

        (new ContactRepository($this->db))->create($payload);
        clear_old();
        redirect_with_flash_data(app_url(ltrim($returnTo, '/')), [
            'type' => 'success',
            'message' => (string) ($settings['contact_success_message'] ?? 'Your request has been sent.'),
            'source' => 'contact',
        ]);
    }
}
