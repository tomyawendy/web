<section id="newsletter" class="newsletter-block<?= !empty($homeNewsletterStage) ? ' home-newsletter-stage' : '' ?>">
    <div class="container newsletter-shell">
        <div class="newsletter-copy">
            <?php $flashMessage = peek_flash(); ?>
            <?php $isSpanish = current_locale() === 'es'; ?>
            <span class="tiny-link"><?= e($isSpanish ? 'BOLETIN' : setting_value($settings ?? [], 'newsletter_kicker_label', 'NEWSLETTER')) ?></span>
            <h2><?= e($isSpanish ? 'Suscribase al boletin Logistics Pulse' : setting_value($settings ?? [], 'newsletter_title', 'Sign Up To The Logistics Pulse Newsletter')) ?></h2>
            <p><?= e($isSpanish ? 'Reciba nuestros insights directamente en su correo al suscribirse a este formulario y entre en un mundo de logistica verdaderamente integrada.' : setting_value($settings ?? [], 'newsletter_body', 'Receive our insights directly in your mailbox by signing up through this form and enter a world of truly integrated logistics.')) ?></p>
            <?php if (($flashMessage['source'] ?? null) === 'newsletter'): ?>
                <div class="flash flash-<?= e((string) $flashMessage['type']) ?>"><?= e((string) $flashMessage['message']) ?></div>
                <?php clear_flash(); ?>
            <?php endif; ?>
            <form class="newsletter-form" method="post" action="<?= e(localized_url('newsletter')) ?>">
                <?= csrf_field() ?>
                <input type="email" name="email" value="<?= e((string) old('newsletter_email')) ?>" placeholder="<?= e($isSpanish ? 'Introduzca su correo electronico' : setting_value($settings ?? [], 'newsletter_placeholder', 'Enter your email address')) ?>" required>
                <input type="hidden" name="return_to" value="<?= e(normalize_return_path(request_path() . '?lang=' . current_locale() . '#newsletter', '/#newsletter')) ?>">
                <button type="submit" class="newsletter-button"><?= e($isSpanish ? 'ENVIAR' : setting_value($settings ?? [], 'newsletter_submit_text', 'SUBMIT')) ?></button>
            </form>
        </div>
    </div>
</section>
