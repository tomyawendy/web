<div class="panel admin-section">
    <div class="toolbar">
        <div class="toolbar-copy">
            <span class="tiny-label">Media library</span>
            <h2>Media Library</h2>
            <p>Upload images or documents once, then reuse the path in pages, service cards, insights, documents, partner logos, and contact visuals.</p>
        </div>
    </div>
    <form class="admin-form" method="post" action="<?= e(admin_url('media/upload')) ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="button-row">
            <label>File Type
                <select name="type">
                    <option value="images">Images</option>
                    <option value="documents">Documents</option>
                </select>
            </label>
            <label>Select File<input type="file" name="media_file" required></label>
        </div>
        <label>Alt Text / Description
            <input name="alt_text" placeholder="Short description for accessibility or internal reference">
        </label>
        <button class="button-primary" type="submit">Upload</button>
    </form>
    <form class="admin-filter-form" method="get" action="<?= e(admin_url('media')) ?>">
        <label>Search
            <input name="q" value="<?= e((string) ($filters['q'] ?? '')) ?>" placeholder="File name, path, or MIME">
        </label>
        <label>Type
            <select name="type">
                <option value="">All files</option>
                <option value="images" <?= ($filters['type'] ?? '') === 'images' ? 'selected' : '' ?>>Images</option>
                <option value="documents" <?= ($filters['type'] ?? '') === 'documents' ? 'selected' : '' ?>>Documents</option>
            </select>
        </label>
        <button class="button-secondary" type="submit">Filter</button>
        <a class="button-secondary" href="<?= e(admin_url('media')) ?>">Reset</a>
    </form>
</div>
<div class="panel admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>Name</th><th>Type</th><th>Preview</th><th>Path</th><th>Copy</th><th>Size</th><th>Uploaded</th><th>Actions</th></tr></thead>
        <tbody>
        <?php if (empty($items)): ?>
            <tr>
                <td colspan="8">No media uploaded yet.</td>
            </tr>
        <?php endif; ?>
        <?php foreach ($items as $item): ?>
            <?php $path = (string) $item['file_path']; ?>
            <tr>
                <td>
                    <a href="<?= e(media_url($path)) ?>" target="_blank"><?= e($item['file_name']) ?></a>
                    <span class="table-muted"><?= e((string) $item['mime_type']) ?></span>
                    <?php if (!empty($item['alt_text'])): ?>
                        <span class="table-muted"><?= e((string) $item['alt_text']) ?></span>
                    <?php endif; ?>
                </td>
                <td><span class="table-badge"><?= e($item['file_type']) ?></span></td>
                <td>
                    <?php if (($item['file_type'] ?? '') === 'images'): ?>
                        <img class="media-thumb" src="<?= e(media_url($path)) ?>" alt="<?= e($item['file_name']) ?>">
                    <?php else: ?>
                        <a class="button-secondary compact-button" href="<?= e(media_url($path)) ?>" target="_blank">Open</a>
                    <?php endif; ?>
                </td>
                <td><code><?= e($path) ?></code></td>
                <td><button class="button-secondary compact-button" type="button" onclick="navigator.clipboard && navigator.clipboard.writeText('<?= e($path) ?>')">Copy path</button></td>
                <td><?= e(number_format(((int) $item['file_size']) / 1024, 1)) ?> KB</td>
                <td><?= e(format_datetime($item['created_at'])) ?></td>
                <td>
                    <form method="post" action="<?= e(admin_url('media/delete')) ?>" onsubmit="return confirm('Delete this media item? Make sure it is not used by a page, service, insight, document, or setting.');">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= e((string) $item['id']) ?>">
                        <button class="button-secondary compact-button danger-button" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
