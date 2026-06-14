<div class="panel admin-section">
    <div class="toolbar">
        <div class="toolbar-copy">
            <span class="tiny-label">Media library</span>
            <h2>Media Library</h2>
            <p>Upload images or documents once, then reuse the file path in banners, service cards, content pages, partner logos, contact visuals, and newsletter sections.</p>
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
        <button class="button-primary" type="submit">Upload</button>
    </form>
</div>
<div class="panel admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>Name</th><th>Type</th><th>MIME</th><th>Path</th><th>Size</th><th>Uploaded</th></tr></thead>
        <tbody>
        <?php if (empty($items)): ?>
            <tr>
                <td colspan="6">No media uploaded yet.</td>
            </tr>
        <?php endif; ?>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><a href="<?= e(media_url((string) $item['file_path'])) ?>" target="_blank"><?= e($item['file_name']) ?></a></td>
                <td><span class="table-badge"><?= e($item['file_type']) ?></span></td>
                <td><?= e($item['mime_type']) ?></td>
                <td><code><?= e($item['file_path']) ?></code></td>
                <td><?= e(number_format(((int) $item['file_size']) / 1024, 1)) ?> KB</td>
                <td><?= e(format_datetime($item['created_at'])) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
