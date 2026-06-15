<?php
$locales = config('app.locales', []);

$groups = [
    [
        'id' => 'branding',
        'title' => 'Branding & Navigation',
        'description' => 'Header labels, logo copy, and footer titles that stay visible across the whole site.',
        'fields' => [
            ['name' => 'site_name', 'label' => 'Site Name', 'type' => 'input', 'default' => 'Planet Aviation'],
            ['name' => 'hero_kicker', 'label' => 'Hero Kicker', 'type' => 'input', 'default' => 'PLANET AVIATION, S.L.,'],
            ['name' => 'nav_home_label', 'label' => 'Nav Home Label', 'type' => 'input', 'default' => 'Home'],
            ['name' => 'nav_about_label', 'label' => 'Nav About Label', 'type' => 'input', 'default' => 'Who We Are?'],
            ['name' => 'nav_services_label', 'label' => 'Nav Services Label', 'type' => 'input', 'default' => 'Our Services'],
            ['name' => 'nav_insights_label', 'label' => 'Nav Insights Label', 'type' => 'input', 'default' => 'Insights'],
            ['name' => 'nav_documents_label', 'label' => 'Nav Documents Label', 'type' => 'input', 'default' => 'Documents'],
            ['name' => 'nav_contact_label', 'label' => 'Nav Contact Label', 'type' => 'input', 'default' => 'Contact'],
            ['name' => 'nav_quote_label', 'label' => 'Nav Quote Label', 'type' => 'input', 'default' => 'GET A QUOTE'],
            ['name' => 'footer_pages_title', 'label' => 'Footer Pages Title', 'type' => 'input', 'default' => 'Pages'],
            ['name' => 'footer_services_title', 'label' => 'Footer Services Title', 'type' => 'input', 'default' => 'Services'],
            ['name' => 'footer_about_title', 'label' => 'Footer About Title', 'type' => 'input', 'default' => 'About'],
            ['name' => 'footer_home_label', 'label' => 'Footer Home Label', 'type' => 'input', 'default' => 'Home'],
            ['name' => 'footer_events_label', 'label' => 'Footer Events Label', 'type' => 'input', 'default' => 'Events'],
            ['name' => 'footer_awards_label', 'label' => 'Footer Awards Label', 'type' => 'input', 'default' => 'Our awards'],
            ['name' => 'footer_contact_label', 'label' => 'Footer Contact Label', 'type' => 'input', 'default' => 'Contact'],
            ['name' => 'footer_news_label', 'label' => 'Footer News Label', 'type' => 'input', 'default' => 'News'],
            ['name' => 'footer_certification_label', 'label' => 'Footer Certification Label', 'type' => 'input', 'default' => 'Obtain IATA certification'],
        ],
    ],
    [
        'id' => 'home',
        'title' => 'Home Hero & About',
        'description' => 'The headline block, intro copy, and first supporting section on the homepage.',
        'fields' => [
            ['name' => 'homepage_title', 'label' => 'Homepage Title', 'type' => 'textarea', 'default' => 'Premium Choice for Air Logistics Solution!'],
            ['name' => 'homepage_subtitle', 'label' => 'Homepage Subtitle', 'type' => 'textarea', 'default' => ''],
            ['name' => 'hero_button_text', 'label' => 'Hero Button Text', 'type' => 'input', 'default' => 'LEARN MORE'],
            ['name' => 'lookup_label', 'label' => 'Lookup Label', 'type' => 'input', 'default' => "I'm looking for"],
            ['name' => 'lookup_insurance_label', 'label' => 'Lookup Fourth Label', 'type' => 'input', 'default' => 'Insurance'],
            ['name' => 'home_about_heading', 'label' => 'Home About Heading', 'type' => 'input', 'default' => 'Your Leading Air Cargo Sales & Service Provider'],
            ['name' => 'home_about_body', 'label' => 'Home About Body', 'type' => 'textarea', 'default' => ''],
            ['name' => 'home_about_button', 'label' => 'Home About Button', 'type' => 'input', 'default' => 'LEARN MORE'],
        ],
    ],
    [
        'id' => 'services',
        'title' => 'Services, Why & World',
        'description' => 'Service rows, proof points, world map, and the badge figures on the homepage.',
        'fields' => [
            ['name' => 'services_kicker_label', 'label' => 'Services Kicker Label', 'type' => 'input', 'default' => 'View all'],
            ['name' => 'services_filter_label', 'label' => 'Services Filter Label', 'type' => 'input', 'default' => 'Products & Services'],
            ['name' => 'services_heading', 'label' => 'Services Heading', 'type' => 'input', 'default' => 'Delivering Service Excellence'],
            ['name' => 'services_intro', 'label' => 'Services Intro', 'type' => 'textarea', 'default' => 'Planet Aviation offers a comprehensive portfolio of air cargo products and services. Every shipment is handled with precision, care, and professionalism.'],
            ['name' => 'services_fourth_home_title', 'label' => 'Fourth Home Service Title', 'type' => 'input', 'default' => 'General Sales & Service Agent'],
            ['name' => 'services_learn_more_label', 'label' => 'Services Learn More Label', 'type' => 'input', 'default' => 'LEARN MORE'],
            ['name' => 'why_heading', 'label' => 'Why Heading', 'type' => 'input', 'default' => 'Why Partners Choose Us'],
            ['name' => 'why_background_image', 'label' => 'Why Background Image Path', 'type' => 'input', 'default' => ''],
            ['name' => 'world_kicker_label', 'label' => 'World Kicker Label', 'type' => 'input', 'default' => 'GLOBAL MANAGEMENT. LOCAL EXPERTISE.'],
            ['name' => 'why_items', 'label' => 'Why Items', 'type' => 'textarea', 'default' => "Independent GSSA\nStrong Financial Background\nDigital Marketing\nMotivated & Experienced Teams\nBusiness Intelligence\nFull Service - Sales to Invoicing"],
            ['name' => 'world_heading', 'label' => 'World Heading', 'type' => 'input', 'default' => 'One World'],
            ['name' => 'world_intro', 'label' => 'World Intro', 'type' => 'textarea', 'default' => 'Local expertise, global cargo reach, and responsive support.'],
            ['name' => 'world_regions', 'label' => 'World Regions', 'type' => 'textarea', 'default' => "Americas\nEurope\nMiddle East\nAfrica\nAsia Pacific"],
            ['name' => 'world_map_image', 'label' => 'World Map Image Path', 'type' => 'input', 'default' => ''],
            ['name' => 'stats_offices', 'label' => 'Stats Offices', 'type' => 'input', 'default' => '100+'],
            ['name' => 'stats_offices_label', 'label' => 'Stats Offices Label', 'type' => 'input', 'default' => 'Global Partners'],
            ['name' => 'stats_support', 'label' => 'Stats Support', 'type' => 'input', 'default' => '24/7'],
            ['name' => 'stats_support_label', 'label' => 'Stats Support Label', 'type' => 'input', 'default' => 'Rapid Response Team'],
            ['name' => 'stats_shipments', 'label' => 'Stats Shipments', 'type' => 'input', 'default' => '16,000+'],
            ['name' => 'stats_shipments_label', 'label' => 'Stats Shipments Label', 'type' => 'input', 'default' => 'Freight Forwarders'],
        ],
    ],
    [
        'id' => 'partners-news',
        'title' => 'Partners & News',
        'description' => 'Logo strip, news card labels, and the document / article action copy.',
        'fields' => [
            ['name' => 'partners_heading', 'label' => 'Partners Heading', 'type' => 'input', 'default' => 'Our Partners'],
            ['name' => 'partners_subtitle', 'label' => 'Partners Subtitle', 'type' => 'input', 'default' => 'These are our collaborators'],
            ['name' => 'partners_list', 'label' => 'Partners List', 'type' => 'textarea', 'default' => "OOCL\nDHL\nMSC\nMNG\nHainan Airlines\nIAC"],
            ['name' => 'partners_logos', 'label' => 'Partners Logos', 'type' => 'textarea', 'default' => ''],
            ['name' => 'news_kicker_label', 'label' => 'News Kicker Label', 'type' => 'input', 'default' => 'INSIGHT'],
            ['name' => 'news_heading', 'label' => 'News Heading', 'type' => 'input', 'default' => 'Latest News'],
            ['name' => 'news_view_all_label', 'label' => 'News View All Label', 'type' => 'input', 'default' => 'VIEW ALL ARTICLES'],
            ['name' => 'read_more_label', 'label' => 'Read More Label', 'type' => 'input', 'default' => 'READ MORE'],
            ['name' => 'download_attachment_label', 'label' => 'Download Attachment Label', 'type' => 'input', 'default' => 'DOWNLOAD ATTACHMENT'],
        ],
    ],
    [
        'id' => 'contact-footer',
        'title' => 'Contact, Newsletter, Footer & Messages',
        'description' => 'Lead form labels, newsletter block, footer copy, and the fallback messages used by the site.',
        'fields' => [
            ['name' => 'contact_heading', 'label' => 'Contact Heading', 'type' => 'input', 'default' => 'Contact Us'],
            ['name' => 'contact_intro', 'label' => 'Contact Intro', 'type' => 'textarea', 'default' => ''],
            ['name' => 'contact_visual_image', 'label' => 'Contact Visual Image Path', 'type' => 'input', 'default' => ''],
            ['name' => 'contact_name_label', 'label' => 'Contact Name Label', 'type' => 'input', 'default' => 'Full Name'],
            ['name' => 'contact_phone_label', 'label' => 'Contact Phone Label', 'type' => 'input', 'default' => 'Phone'],
            ['name' => 'contact_email_label', 'label' => 'Contact Email Label', 'type' => 'input', 'default' => 'Email Address'],
            ['name' => 'contact_company_label', 'label' => 'Contact Company Label', 'type' => 'input', 'default' => 'Company'],
            ['name' => 'contact_message_label', 'label' => 'Contact Message Label', 'type' => 'input', 'default' => 'Message'],
            ['name' => 'contact_submit_text', 'label' => 'Contact Submit Text', 'type' => 'input', 'default' => 'SUBMIT'],
            ['name' => 'newsletter_title', 'label' => 'Newsletter Title', 'type' => 'textarea', 'default' => 'Sign Up To The Logistics Pulse Newsletter'],
            ['name' => 'newsletter_body', 'label' => 'Newsletter Body', 'type' => 'textarea', 'default' => ''],
            ['name' => 'newsletter_placeholder', 'label' => 'Newsletter Placeholder', 'type' => 'input', 'default' => 'Enter your email address'],
            ['name' => 'newsletter_submit_text', 'label' => 'Newsletter Submit Text', 'type' => 'input', 'default' => 'SUBMIT'],
            ['name' => 'newsletter_background_image', 'label' => 'Newsletter Background Image Path', 'type' => 'input', 'default' => ''],
            ['name' => 'contact_email', 'label' => 'Contact Email', 'type' => 'input', 'default' => 'ops@planetaviation.com'],
            ['name' => 'contact_phone', 'label' => 'Contact Phone', 'type' => 'input', 'default' => ''],
            ['name' => 'office_address', 'label' => 'Office Address', 'type' => 'textarea', 'default' => ''],
            ['name' => 'footer_copyright', 'label' => 'Footer Copyright', 'type' => 'textarea', 'default' => 'Copyright (c) Planet Aviation. All Rights Reserved'],
            ['name' => 'page_not_found_message', 'label' => 'Page Not Found Message', 'type' => 'textarea', 'default' => 'The requested page is not available.'],
            ['name' => 'service_not_found_message', 'label' => 'Service Not Found Message', 'type' => 'textarea', 'default' => 'The requested service is not available.'],
            ['name' => 'post_not_found_message', 'label' => 'Post Not Found Message', 'type' => 'textarea', 'default' => 'The requested content is not available.'],
            ['name' => 'contact_error_invalid', 'label' => 'Contact Invalid Session Message', 'type' => 'textarea', 'default' => 'Your session expired. Please try again.'],
            ['name' => 'contact_error_required', 'label' => 'Contact Error Message', 'type' => 'textarea', 'default' => 'Name, email, and message are required.'],
            ['name' => 'contact_success_message', 'label' => 'Contact Success Message', 'type' => 'textarea', 'default' => 'Your request has been sent.'],
            ['name' => 'newsletter_error_required', 'label' => 'Newsletter Error Message', 'type' => 'textarea', 'default' => 'Please enter a valid email address.'],
            ['name' => 'newsletter_error_duplicate', 'label' => 'Newsletter Duplicate Message', 'type' => 'textarea', 'default' => 'This email address is already subscribed.'],
            ['name' => 'newsletter_success_message', 'label' => 'Newsletter Success Message', 'type' => 'textarea', 'default' => 'Thank you for subscribing to our newsletter.'],
        ],
    ],
    [
        'id' => 'seo',
        'title' => 'SEO Settings',
        'description' => 'Site-level fallback SEO fields and homepage SEO fields. Detail pages still use their own SEO fields first.',
        'fields' => [
            ['name' => 'site_meta_title', 'label' => 'Default Meta Title', 'type' => 'input', 'default' => 'Planet Aviation'],
            ['name' => 'site_meta_keywords', 'label' => 'Default Meta Keywords', 'type' => 'textarea', 'default' => 'aviation, air cargo, logistics, GSSA'],
            ['name' => 'site_meta_description', 'label' => 'Default Meta Description', 'type' => 'textarea', 'default' => 'Planet Aviation provides air cargo, GSSA, logistics, handling, trucking, and insurance solutions.'],
            ['name' => 'site_og_image', 'label' => 'Default Share Image Path', 'type' => 'input', 'default' => 'assets/figma/hero-plane.png'],
            ['name' => 'homepage_meta_title', 'label' => 'Homepage Meta Title', 'type' => 'input', 'default' => 'Premium Choice For Air Logistics Solution!'],
            ['name' => 'homepage_meta_keywords', 'label' => 'Homepage Meta Keywords', 'type' => 'textarea', 'default' => 'air logistics, air cargo, GSSA, freight forwarding'],
            ['name' => 'homepage_meta_description', 'label' => 'Homepage Meta Description', 'type' => 'textarea', 'default' => 'Specializing in air freight operations across Europe, Asia, Middle East and Latin America.'],
            ['name' => 'homepage_og_image', 'label' => 'Homepage Share Image Path', 'type' => 'input', 'default' => 'assets/figma/hero-plane.png'],
        ],
    ],
];
?>
<form class="admin-form panel settings-form" method="post" action="<?= e(admin_url('settings')) ?>">
    <?= csrf_field() ?>
    <div class="settings-hero">
        <div>
            <h2>Site Settings</h2>
            <p>Everything that appears on the public site is grouped by frontend section, so the team can update content without hunting through one giant form.</p>
            <p class="field-note">Important: approved Figma stage areas are visually locked. Change text, links, and reusable paths here, but do not expect every stage image to change unless that section is rebuilt and screenshot-checked.</p>
        </div>
        <div class="settings-badges">
            <span><?= e((string) count($locales)) ?> locales</span>
            <span><?= e((string) count($groups)) ?> sections</span>
        </div>
    </div>

    <div class="settings-locale-nav">
        <?php foreach ($locales as $locale => $label): ?>
            <a href="#locale-<?= e($locale) ?>"><?= e($label) ?></a>
        <?php endforeach; ?>
    </div>

    <?php foreach ($locales as $locale => $label): ?>
        <section class="settings-locale-card" id="locale-<?= e($locale) ?>">
            <div class="settings-locale-head">
                <div>
                    <span class="settings-locale-kicker">Locale</span>
                    <h3><?= e($label) ?></h3>
                </div>
                <span><?= e($locale) ?></span>
            </div>

            <?php foreach ($groups as $group): ?>
                <fieldset class="settings-group" id="<?= e($group['id'] . '-' . $locale) ?>">
                    <legend><?= e($group['title']) ?></legend>
                    <p><?= e($group['description']) ?></p>
                    <div class="settings-grid">
                        <?php foreach ($group['fields'] as $field): ?>
                            <?php
                            $fieldName = $field['name'] . '_' . $locale;
                            $fieldValue = (string) ($settings[$locale][$field['name']] ?? $field['default'] ?? '');
                            $isWide = $field['type'] === 'textarea';
                            ?>
                            <label class="<?= $isWide ? 'field-wide' : '' ?>">
                                <span><?= e($field['label']) ?></span>
                                <?php if ($field['type'] === 'textarea'): ?>
                                    <textarea name="<?= e($fieldName) ?>"><?= e($fieldValue) ?></textarea>
                                <?php else: ?>
                                    <input name="<?= e($fieldName) ?>" value="<?= e($fieldValue) ?>">
                                <?php endif; ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <?php if ($group['id'] === 'partners-news'): ?>
                        <p class="field-note">Partners logos should be entered one per line in the format: <strong>Partner Name|assets/uploads/partner-logo.png</strong>.</p>
                    <?php endif; ?>
                </fieldset>
            <?php endforeach; ?>
        </section>
    <?php endforeach; ?>

    <div class="settings-save-bar">
        <button class="button-primary" type="submit">Save Site Settings</button>
    </div>
</form>
