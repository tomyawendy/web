<?php $item = $item ?? null; ?>
<form class="admin-form panel" method="post" action="<?= e(admin_url('posts/save')) ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= e((string) ($item['id'] ?? '')) ?>">
    <input type="hidden" name="type" value="<?= e($type) ?>">
    <input type="hidden" name="existing_attachment_path" value="<?= e((string) ($item['attachment_path'] ?? '')) ?>">
    <input type="hidden" name="existing_attachment_name" value="<?= e((string) ($item['attachment_name'] ?? '')) ?>">
    <h2><?= e($metaTitle ?? ($type === 'news' ? 'Insight' : 'Document')) ?></h2>
    <p><?= $type === 'news' ? 'Insights appear in the Latest News section and the Insights listing page.' : 'Documents appear on the Documents listing page and can expose downloadable attachments.' ?></p>
    <label>Slug<input name="slug" value="<?= e((string) ($item['slug'] ?? '')) ?>" required></label>
    <div class="button-row">
        <label>Category
            <select name="category_id">
                <option value="">Select</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= e((string) $category['id']) ?>" <?= (int) ($item['category_id'] ?? 0) === (int) $category['id'] ? 'selected' : '' ?>><?= e($category['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
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
        <label>Published At<input type="datetime-local" name="published_at" value="<?= !empty($item['published_at']) ? e(date('Y-m-d\TH:i', strtotime($item['published_at']))) : '' ?>"></label>
        <label>Sort Order<input name="sort_order" type="number" value="<?= e((string) ($item['sort_order'] ?? 0)) ?>"></label>
    </div>
    <div class="button-row">
        <label class="checkbox-line"><input type="checkbox" name="is_pinned" value="1" <?= !empty($item['is_pinned']) ? 'checked' : '' ?>> Pinned</label>
        <label class="checkbox-line"><input type="checkbox" name="is_featured" value="1" <?= !empty($item['is_featured']) ? 'checked' : '' ?>> Featured</label>
    </div>
    <label>Attachment (documents only)<input type="file" name="attachment"></label>
    <?php if (!empty($item['attachment_name'])): ?>
        <p>Current attachment: <a href="<?= e(media_url((string) $item['attachment_path'])) ?>" target="_blank"><?= e($item['attachment_name']) ?></a></p>
    <?php endif; ?>
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
    <button class="button-primary" type="submit"><?= $type === 'news' ? 'Save Insight' : 'Save Document' ?></button>
</form>
