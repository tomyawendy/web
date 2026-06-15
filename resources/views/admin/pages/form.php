<?php $item = $item ?? null; ?>
<form class="admin-form panel" method="post" action="<?= e(admin_url('pages/save')) ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= e((string) ($item['id'] ?? '')) ?>">
    <h2><?= e($metaTitle ?? 'Page') ?></h2>
    <p>Use `about` for the Who We Are page and `contact` for the contact page sections shown on the frontend.</p>
    <label>Slug<input name="slug" value="<?= e((string) ($item['slug'] ?? '')) ?>" required></label>
    <label>Template
        <select name="template">
            <?php $currentTemplate = (string) ($item['template'] ?? 'default'); ?>
            <option value="default" <?= $currentTemplate === 'default' ? 'selected' : '' ?>>default</option>
            <option value="about" <?= $currentTemplate === 'about' ? 'selected' : '' ?>>about</option>
            <option value="contact" <?= $currentTemplate === 'contact' ? 'selected' : '' ?>>contact</option>
        </select>
    </label>
    <label>SEO Image Path<input name="seo_image" value="<?= e((string) ($item['seo_image'] ?? '')) ?>"></label>
    <?php if (!empty($item['seo_image'])): ?>
        <p>Current SEO image: <a href="<?= e(media_url((string) $item['seo_image'])) ?>" target="_blank"><?= e((string) $item['seo_image']) ?></a></p>
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
            <label>Excerpt<textarea name="excerpt_<?= e($locale) ?>"><?= e(translated_field($item, $locale, 'excerpt')) ?></textarea></label>
            <label>Content<textarea name="content_<?= e($locale) ?>"><?= e(translated_field($item, $locale, 'content')) ?></textarea></label>
            <label>SEO Title<input name="seo_title_<?= e($locale) ?>" value="<?= e(translated_field($item, $locale, 'seo_title')) ?>"></label>
            <label>SEO Keywords<input name="seo_keywords_<?= e($locale) ?>" value="<?= e(translated_field($item, $locale, 'seo_keywords')) ?>"></label>
            <label>SEO Description<textarea name="seo_description_<?= e($locale) ?>"><?= e(translated_field($item, $locale, 'seo_description')) ?></textarea></label>
        </fieldset>
    <?php endforeach; ?>
    <button class="button-primary" type="submit">Save Content Page</button>
</form>
