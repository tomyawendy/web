<div class="panel admin-section">
    <div class="toolbar">
        <div class="toolbar-copy">
            <span class="tiny-label">Leads</span>
            <h2>Contact Submissions</h2>
            <p>Review inquiries from the public site, mark the follow-up status, and keep internal notes for the team.</p>
        </div>
        <a class="button-primary" href="<?= e(admin_url('contacts/export')) ?>">Export CSV</a>
    </div>
</div>
<div class="panel admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>Name</th><th>Contact</th><th>Locale</th><th>Subject / Message</th><th>Status</th><th>Submitted</th><th>Follow-up</th></tr></thead>
        <tbody>
        <?php if (empty($items)): ?>
            <tr>
                <td colspan="7">No contact submissions yet.</td>
            </tr>
        <?php endif; ?>
        <?php foreach ($items as $item): ?>
            <?php $status = (string) ($item['status'] ?? 'new'); ?>
            <tr>
                <td>
                    <strong><?= e($item['name']) ?></strong>
                    <span class="table-muted"><?= e((string) $item['company']) ?></span>
                </td>
                <td>
                    <a href="mailto:<?= e($item['email']) ?>"><?= e($item['email']) ?></a>
                    <span class="table-muted"><?= e((string) $item['phone']) ?></span>
                </td>
                <td><span class="table-badge"><?= e(locale_label((string) $item['locale'])) ?></span></td>
                <td title="<?= e((string) $item['message']) ?>">
                    <strong><?= e((string) $item['subject']) ?></strong>
                    <span class="table-muted"><?= e(truncate_text((string) $item['message'], 160)) ?></span>
                </td>
                <td><span class="status-badge status-badge-<?= e($status) ?>"><?= e(str_replace('_', ' ', ucfirst($status))) ?></span></td>
                <td><?= e(format_datetime($item['created_at'])) ?></td>
                <td>
                    <form class="inline-admin-form" method="post" action="<?= e(admin_url('contacts/status')) ?>">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= e((string) $item['id']) ?>">
                        <select name="status">
                            <option value="new" <?= $status === 'new' ? 'selected' : '' ?>>New</option>
                            <option value="in_progress" <?= $status === 'in_progress' ? 'selected' : '' ?>>In progress</option>
                            <option value="done" <?= $status === 'done' ? 'selected' : '' ?>>Done</option>
                        </select>
                        <textarea name="admin_note" placeholder="Internal note"><?= e((string) ($item['admin_note'] ?? '')) ?></textarea>
                        <button class="button-secondary compact-button" type="submit">Save</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
