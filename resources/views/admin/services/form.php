<?php $item = $item ?? null; ?>
<form class="admin-form panel" method="post" action="<?= e(admin_url('services/save')) ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= e((string) ($item['id'] ?? '')) ?>">
    <h2><?= e($metaTitle ?? 'Service Card') ?></h2>
    <p>These cards power both the homepage service rows and the dedicated Our Services page.</p>
    <label>Slug<input name="slug" value="<?= e((string) ($item['slug'] ?? '')) ?>" required></label>
    <div class="button-row">
        <label>Icon<input name="icon" value="<?= e((string) ($item['icon'] ?? '')) ?>"></label>
        <label>Cover Image Path<input name="cover_image" value="<?= e((string) ($item['cover_image'] ?? '')) ?>"></label>
    </div>
    <?php if (!empty($item['cover_image'])): ?>
        <p>Current cover image: <a href="<?= e(media_url((string) $item['cover_image'])) ?>" target="_blank"><?= e((string) $item['cover_image']) ?></a></p>
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
            <label>Summary<textarea name="summary_<?= e($locale) ?>"><?= e(translated_field($item, $locale, 'summary')) ?></textarea></label>
            <label>Content<textarea name="content_<?= e($locale) ?>"><?= e(translated_field($item, $locale, 'content')) ?></textarea></label>
            <label>SEO Title<input name="seo_title_<?= e($locale) ?>" value="<?= e(translated_field($item, $locale, 'seo_title')) ?>"></label>
            <label>SEO Keywords<input name="seo_keywords_<?= e($locale) ?>" value="<?= e(translated_field($item, $locale, 'seo_keywords')) ?>"></label>
            <label>SEO Description<textarea name="seo_description_<?= e($locale) ?>"><?= e(translated_field($item, $locale, 'seo_description')) ?></textarea></label>
        </fieldset>
    <?php endforeach; ?>
    <button class="button-primary" type="submit">Save Service Card</button>
</form>
