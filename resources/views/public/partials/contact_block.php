<?php
$contactContent = resolved_translation($contactPage ?? null);
$flashMessage = peek_flash();
$contactDetails = array_filter([
    setting_value($settings ?? [], 'contact_phone'),
    setting_value($settings ?? [], 'contact_email'),
    setting_value($settings ?? [], 'office_address'),
], static fn (string $value): bool => trim($value) !== '');
$contactSubject = current_locale() === 'es'
    ? 'Consulta desde el sitio web de Planet Aviation'
    : trim(site_name($settings ?? []) . ' Website Inquiry');
$returnTo = normalize_return_path(request_path() . '?lang=' . current_locale() . '#contact', '/contact#contact');
?>
<section id="contact" class="contact-block<?= !empty($homeContactStage) ? ' home-contact-stage' : '' ?>">
    <div class="container contact-shell">
        <div class="contact-visual"<?= background_style(setting_value($settings ?? [], 'contact_visual_image')) ?>></div>
        <div class="contact-copy">
            <span class="tiny-link"><?= e(setting_value($settings ?? [], 'contact_kicker_label', 'CONTACT')) ?></span>
            <h2><?= e(setting_value($settings ?? [], 'contact_heading', $contactContent['title'] ?? 'Contact Us')) ?></h2>
            <p><?= e(setting_value($settings ?? [], 'contact_intro', $contactContent['excerpt'] ?? 'If you need further information about our services, please fill out the form below.')) ?></p>
            <?php if ($contactDetails): ?>
                <div class="contact-meta">
                    <?php foreach ($contactDetails as $detail): ?>
                        <span><?= e($detail) ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if ($flashMessage && (($flashMessage['source'] ?? 'contact') === 'contact')): ?>
                <div class="flash flash-<?= e($flashMessage['type']) ?>"><?= e($flashMessage['message']) ?></div>
                <?php clear_flash(); ?>
            <?php endif; ?>
            <form class="contact-grid" method="post" action="<?= e(localized_url('contact')) ?>">
                <?= csrf_field() ?>
                <label><?= e(setting_value($settings ?? [], 'contact_name_label', 'Full Name')) ?> *<input name="name" value="<?= e((string) old('name')) ?>" required></label>
                <label><?= e(setting_value($settings ?? [], 'contact_phone_label', 'Phone')) ?><input name="phone" value="<?= e((string) old('phone')) ?>"></label>
                <label><?= e(setting_value($settings ?? [], 'contact_email_label', 'Email Address')) ?> *<input name="email" type="email" value="<?= e((string) old('email')) ?>" required></label>
                <label><?= e(setting_value($settings ?? [], 'contact_company_label', 'Company')) ?><input name="company" value="<?= e((string) old('company')) ?>"></label>
                <label class="span-2"><?= e(setting_value($settings ?? [], 'contact_message_label', 'Message')) ?> *<textarea name="message" required><?= e((string) old('message')) ?></textarea></label>
                <input type="hidden" name="subject" value="<?= e($contactSubject) ?>">
                <input type="hidden" name="return_to" value="<?= e($returnTo) ?>">
                <div class="span-2 submit-wrap">
                    <button class="submit-button" type="submit"><?= e(setting_value($settings ?? [], 'contact_submit_text', 'SUBMIT')) ?></button>
                </div>
            </form>
        </div>
    </div>
</section>
