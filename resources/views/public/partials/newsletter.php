<section id="newsletter" class="newsletter-block<?= !empty($homeNewsletterStage) ? ' home-newsletter-stage' : '' ?>">
    <div class="container newsletter-shell">
        <div class="newsletter-copy">
            <?php $flashMessage = peek_flash(); ?>
            <span class="tiny-link"><?= e(setting_value($settings ?? [], 'newsletter_kicker_label', 'NEWSLETTER')) ?></span>
            <h2><?= e(setting_value($settings ?? [], 'newsletter_title', 'Sign Up To The Logistics Pulse Newsletter')) ?></h2>
            <p><?= e(setting_value($settings ?? [], 'newsletter_body', 'Receive our insights directly in your mailbox by signing up through this form and enter a world of truly integrated logistics.')) ?></p>
            <?php if (($flashMessage['source'] ?? null) === 'newsletter'): ?>
                <div class="flash flash-<?= e((string) $flashMessage['type']) ?>"><?= e((string) $flashMessage['message']) ?></div>
                <?php clear_flash(); ?>
            <?php endif; ?>
            <form class="newsletter-form" method="post" action="<?= e(app_url('newsletter')) ?>">
                <?= csrf_field() ?>
                <input type="email" name="email" value="<?= e((string) old('newsletter_email')) ?>" placeholder="<?= e(setting_value($settings ?? [], 'newsletter_placeholder', 'Enter your email address')) ?>" required>
                <input type="hidden" name="return_to" value="<?= e(normalize_return_path(request_path() . '#newsletter', '/#newsletter')) ?>">
                <button type="submit" class="newsletter-button"><?= e(setting_value($settings ?? [], 'newsletter_submit_text', 'SUBMIT')) ?></button>
            </form>
        </div>
    </div>
</section>
