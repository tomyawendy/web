<?php $item = $item ?? null; ?>
<form class="admin-form panel" method="post" action="<?= e(admin_url('banners/save')) ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= e((string) ($item['id'] ?? '')) ?>">
    <h2><?= e($metaTitle ?? 'Banner') ?></h2>
    <p>This banner controls the homepage hero headline, supporting text, CTA label, and target link.</p>
    <div class="button-row">
        <label>Image Path<input name="image" value="<?= e((string) ($item['image'] ?? '')) ?>"></label>
        <label>Link<input name="link" value="<?= e((string) ($item['link'] ?? '')) ?>"></label>
    </div>
    <?php if (!empty($item['image'])): ?>
        <p>Current banner image: <a href="<?= e(media_url((string) $item['image'])) ?>" target="_blank"><?= e((string) $item['image']) ?></a></p>
    <?php endif; ?>
    <div class="button-row">
        <label>Status
            <select name="status">
                <?php foreach (status_options() as $value => $label): ?>
                    <option value="<?= e($value) ?>" <?= ($item['status'] ?? 'draft') === $value ? 'selected' : '' ?>><?= e($label) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Sort Order<input name="sort_order" type="number" value="<?= e((string) ($item['sort_order'] ?? 0)) ?>"></label>
    </div>
    <?php foreach (config('app.locales', []) as $locale => $label): ?>
        <fieldset>
            <legend><?= e($label) ?></legend>
            <label>Title<input name="title_<?= e($locale) ?>" value="<?= e(translated_field($item, $locale, 'title')) ?>"></label>
            <label>Subtitle<textarea name="subtitle_<?= e($locale) ?>"><?= e(translated_field($item, $locale, 'subtitle')) ?></textarea></label>
            <label>Button Text<input name="button_text_<?= e($locale) ?>" value="<?= e(translated_field($item, $locale, 'button_text')) ?>"></label>
        </fieldset>
    <?php endforeach; ?>
    <button class="button-primary" type="submit">Save Hero Banner</button>
</form>
