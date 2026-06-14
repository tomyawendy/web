<?php

declare(strict_types=1);

namespace App\Http\Controllers\PublicSite;

use App\Core\Controller;
use App\Repositories\NewsletterRepository;
use App\Repositories\SettingRepository;
use PDOException;

class NewsletterController extends Controller
{
    public function subscribe(): void
    {
        $settings = (new SettingRepository($this->db))->allGrouped()[current_locale()] ?? [];
        $returnTo = normalize_return_path((string) $this->request->input('return_to'), request_path() . '#newsletter');

        if (!verify_csrf($this->request->input('_csrf'))) {
            redirect_with_flash_data(app_url(ltrim($returnTo, '/')), [
                'type' => 'error',
                'message' => (string) ($settings['contact_error_invalid'] ?? session_expired_message()),
                'source' => 'newsletter',
            ]);
        }

        $email = trim((string) $this->request->input('email'));
        with_old(['newsletter_email' => $email]);

        if ($email === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            redirect_with_flash_data(app_url(ltrim($returnTo, '/')), [
                'type' => 'error',
                'message' => (string) ($settings['newsletter_error_required'] ?? newsletter_email_required_message()),
                'source' => 'newsletter',
            ]);
        }

        try {
            (new NewsletterRepository($this->db))->create([
                'email' => $email,
                'locale' => current_locale(),
                'source_path' => request_path(),
            ]);
        } catch (PDOException $exception) {
            $message = is_duplicate_key_error($exception)
                ? (string) ($settings['newsletter_error_duplicate'] ?? newsletter_email_duplicate_message())
                : 'We could not save your newsletter request. Please try again.';

            redirect_with_flash_data(app_url(ltrim($returnTo, '/')), [
                'type' => 'error',
                'message' => $message,
                'source' => 'newsletter',
            ]);
        }

        clear_old();
        redirect_with_flash_data(app_url(ltrim($returnTo, '/')), [
            'type' => 'success',
            'message' => (string) ($settings['newsletter_success_message'] ?? newsletter_success_message()),
            'source' => 'newsletter',
        ]);
    }
}
