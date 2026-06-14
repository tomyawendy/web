<div class="panel admin-section">
    <div class="toolbar">
        <div class="toolbar-copy">
            <span class="tiny-label">Leads</span>
            <h2>Contact Submissions</h2>
            <p>Review every inquiry sent from the public site. This page keeps the contact history in one place so the team can follow up quickly.</p>
        </div>
    </div>
</div>
<div class="panel admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>Name</th><th>Company</th><th>Email</th><th>Phone</th><th>Locale</th><th>Subject</th><th>Message</th><th>Submitted</th></tr></thead>
        <tbody>
        <?php if (empty($items)): ?>
            <tr>
                <td colspan="8">No contact submissions yet.</td>
            </tr>
        <?php endif; ?>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= e($item['name']) ?></td>
                <td><?= e($item['company']) ?></td>
                <td><a href="mailto:<?= e($item['email']) ?>"><?= e($item['email']) ?></a></td>
                <td><?= e($item['phone']) ?></td>
                <td><span class="table-badge"><?= e(locale_label((string) $item['locale'])) ?></span></td>
                <td><?= e($item['subject']) ?></td>
                <td title="<?= e((string) $item['message']) ?>"><?= e(truncate_text((string) $item['message'])) ?></td>
                <td><?= e(format_datetime($item['created_at'])) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
