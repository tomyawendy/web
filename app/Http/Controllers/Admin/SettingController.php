<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Core\Controller;
use App\Repositories\SettingRepository;
use App\Services\ActivityLogService;
use PDOException;

class SettingController extends Controller
{
    public function edit(): void
    {
        $this->view('admin/settings/form', [
            'settings' => (new SettingRepository($this->db))->allGrouped(),
            'metaTitle' => 'Site Settings',
        ], 'layouts/admin');
    }

    public function save(): void
    {
        if (!verify_csrf($this->request->input('_csrf'))) {
            redirect_with_flash(admin_url('settings'), 'error', session_expired_message());
        }

        $payload = [];
        foreach (array_keys(config('app.locales', [])) as $locale) {
            $payload[$locale] = [
                'site_name' => (string) $this->request->input("site_name_{$locale}"),
                'hero_kicker' => (string) $this->request->input("hero_kicker_{$locale}"),
                'nav_home_label' => (string) $this->request->input("nav_home_label_{$locale}"),
                'nav_about_label' => (string) $this->request->input("nav_about_label_{$locale}"),
                'nav_services_label' => (string) $this->request->input("nav_services_label_{$locale}"),
                'nav_insights_label' => (string) $this->request->input("nav_insights_label_{$locale}"),
                'nav_documents_label' => (string) $this->request->input("nav_documents_label_{$locale}"),
                'nav_contact_label' => (string) $this->request->input("nav_contact_label_{$locale}"),
                'nav_quote_label' => (string) $this->request->input("nav_quote_label_{$locale}"),
                'homepage_title' => (string) $this->request->input("homepage_title_{$locale}"),
                'homepage_subtitle' => (string) $this->request->input("homepage_subtitle_{$locale}"),
                'hero_button_text' => (string) $this->request->input("hero_button_text_{$locale}"),
                'lookup_label' => (string) $this->request->input("lookup_label_{$locale}"),
                'lookup_insurance_label' => (string) $this->request->input("lookup_insurance_label_{$locale}"),
                'home_about_heading' => (string) $this->request->input("home_about_heading_{$locale}"),
                'home_about_body' => (string) $this->request->input("home_about_body_{$locale}"),
                'home_about_button' => (string) $this->request->input("home_about_button_{$locale}"),
                'services_kicker_label' => (string) $this->request->input("services_kicker_label_{$locale}"),
                'services_filter_label' => (string) $this->request->input("services_filter_label_{$locale}"),
                'services_heading' => (string) $this->request->input("services_heading_{$locale}"),
                'services_intro' => (string) $this->request->input("services_intro_{$locale}"),
                'services_fourth_home_title' => (string) $this->request->input("services_fourth_home_title_{$locale}"),
                'services_impact_label' => (string) $this->request->input("services_impact_label_{$locale}"),
                'services_learn_more_label' => (string) $this->request->input("services_learn_more_label_{$locale}"),
                'why_heading' => (string) $this->request->input("why_heading_{$locale}"),
                'why_background_image' => (string) $this->request->input("why_background_image_{$locale}"),
                'world_kicker_label' => (string) $this->request->input("world_kicker_label_{$locale}"),
                'why_items' => (string) $this->request->input("why_items_{$locale}"),
                'world_heading' => (string) $this->request->input("world_heading_{$locale}"),
                'world_intro' => (string) $this->request->input("world_intro_{$locale}"),
                'world_regions' => (string) $this->request->input("world_regions_{$locale}"),
                'world_map_image' => (string) $this->request->input("world_map_image_{$locale}"),
                'stats_offices' => (string) $this->request->input("stats_offices_{$locale}"),
                'stats_offices_label' => (string) $this->request->input("stats_offices_label_{$locale}"),
                'stats_support' => (string) $this->request->input("stats_support_{$locale}"),
                'stats_support_label' => (string) $this->request->input("stats_support_label_{$locale}"),
                'stats_shipments' => (string) $this->request->input("stats_shipments_{$locale}"),
                'stats_shipments_label' => (string) $this->request->input("stats_shipments_label_{$locale}"),
                'partners_heading' => (string) $this->request->input("partners_heading_{$locale}"),
                'partners_subtitle' => (string) $this->request->input("partners_subtitle_{$locale}"),
                'partners_list' => (string) $this->request->input("partners_list_{$locale}"),
                'partners_logos' => (string) $this->request->input("partners_logos_{$locale}"),
                'news_kicker_label' => (string) $this->request->input("news_kicker_label_{$locale}"),
                'news_heading' => (string) $this->request->input("news_heading_{$locale}"),
                'news_view_all_label' => (string) $this->request->input("news_view_all_label_{$locale}"),
                'read_more_label' => (string) $this->request->input("read_more_label_{$locale}"),
                'back_to_insights_label' => (string) $this->request->input("back_to_insights_label_{$locale}"),
                'back_to_documents_label' => (string) $this->request->input("back_to_documents_label_{$locale}"),
                'download_attachment_label' => (string) $this->request->input("download_attachment_label_{$locale}"),
                'documents_intro' => (string) $this->request->input("documents_intro_{$locale}"),
                'empty_insights_title' => (string) $this->request->input("empty_insights_title_{$locale}"),
                'empty_insights_body' => (string) $this->request->input("empty_insights_body_{$locale}"),
                'empty_documents_title' => (string) $this->request->input("empty_documents_title_{$locale}"),
                'empty_documents_body' => (string) $this->request->input("empty_documents_body_{$locale}"),
                'contact_kicker_label' => (string) $this->request->input("contact_kicker_label_{$locale}"),
                'contact_heading' => (string) $this->request->input("contact_heading_{$locale}"),
                'contact_intro' => (string) $this->request->input("contact_intro_{$locale}"),
                'contact_visual_image' => (string) $this->request->input("contact_visual_image_{$locale}"),
                'contact_name_label' => (string) $this->request->input("contact_name_label_{$locale}"),
                'contact_phone_label' => (string) $this->request->input("contact_phone_label_{$locale}"),
                'contact_email_label' => (string) $this->request->input("contact_email_label_{$locale}"),
                'contact_company_label' => (string) $this->request->input("contact_company_label_{$locale}"),
                'contact_message_label' => (string) $this->request->input("contact_message_label_{$locale}"),
                'contact_submit_text' => (string) $this->request->input("contact_submit_text_{$locale}"),
                'newsletter_title' => (string) $this->request->input("newsletter_title_{$locale}"),
                'newsletter_body' => (string) $this->request->input("newsletter_body_{$locale}"),
                'newsletter_kicker_label' => (string) $this->request->input("newsletter_kicker_label_{$locale}"),
                'newsletter_placeholder' => (string) $this->request->input("newsletter_placeholder_{$locale}"),
                'newsletter_submit_text' => (string) $this->request->input("newsletter_submit_text_{$locale}"),
                'newsletter_background_image' => (string) $this->request->input("newsletter_background_image_{$locale}"),
                'contact_email' => (string) $this->request->input("contact_email_{$locale}"),
                'contact_phone' => (string) $this->request->input("contact_phone_{$locale}"),
                'office_address' => (string) $this->request->input("office_address_{$locale}"),
                'footer_pages_title' => (string) $this->request->input("footer_pages_title_{$locale}"),
                'footer_services_title' => (string) $this->request->input("footer_services_title_{$locale}"),
                'footer_about_title' => (string) $this->request->input("footer_about_title_{$locale}"),
                'footer_home_label' => (string) $this->request->input("footer_home_label_{$locale}"),
                'footer_events_label' => (string) $this->request->input("footer_events_label_{$locale}"),
                'footer_awards_label' => (string) $this->request->input("footer_awards_label_{$locale}"),
                'footer_contact_label' => (string) $this->request->input("footer_contact_label_{$locale}"),
                'footer_news_label' => (string) $this->request->input("footer_news_label_{$locale}"),
                'footer_certification_label' => (string) $this->request->input("footer_certification_label_{$locale}"),
                'footer_copyright' => (string) $this->request->input("footer_copyright_{$locale}"),
                'page_not_found_message' => (string) $this->request->input("page_not_found_message_{$locale}"),
                'service_not_found_message' => (string) $this->request->input("service_not_found_message_{$locale}"),
                'post_not_found_message' => (string) $this->request->input("post_not_found_message_{$locale}"),
                'contact_error_invalid' => (string) $this->request->input("contact_error_invalid_{$locale}"),
                'contact_error_required' => (string) $this->request->input("contact_error_required_{$locale}"),
                'contact_success_message' => (string) $this->request->input("contact_success_message_{$locale}"),
                'newsletter_error_required' => (string) $this->request->input("newsletter_error_required_{$locale}"),
                'newsletter_error_duplicate' => (string) $this->request->input("newsletter_error_duplicate_{$locale}"),
                'newsletter_success_message' => (string) $this->request->input("newsletter_success_message_{$locale}"),
                'site_meta_title' => (string) $this->request->input("site_meta_title_{$locale}"),
                'site_meta_keywords' => (string) $this->request->input("site_meta_keywords_{$locale}"),
                'site_meta_description' => (string) $this->request->input("site_meta_description_{$locale}"),
                'site_og_image' => (string) $this->request->input("site_og_image_{$locale}"),
                'homepage_meta_title' => (string) $this->request->input("homepage_meta_title_{$locale}"),
                'homepage_meta_keywords' => (string) $this->request->input("homepage_meta_keywords_{$locale}"),
                'homepage_meta_description' => (string) $this->request->input("homepage_meta_description_{$locale}"),
                'homepage_og_image' => (string) $this->request->input("homepage_og_image_{$locale}"),
            ];
        }

        try {
            (new SettingRepository($this->db))->saveMany($payload);
        } catch (PDOException $exception) {
            redirect_with_flash(admin_url('settings'), 'error', 'We could not save the site settings. Please try again.');
        }
        (new ActivityLogService($this->db))->log($_SESSION['admin']['id'] ?? null, 'save', 'settings', null, 'Updated site settings');
        redirect_with_flash(admin_url('settings'), 'success', 'Site settings saved successfully.');
    }
}
