<?php
$headingKicker = $headingKicker ?? '';
$headingTitle = $headingTitle ?? '';
$headingTitleTag = $headingTitleTag ?? 'h2';
$headingDescription = $headingDescription ?? '';
$headingActionText = $headingActionText ?? '';
$headingActionHref = $headingActionHref ?? '';
$headingCenter = (bool) ($headingCenter ?? false);
$headingTitleTag = in_array($headingTitleTag, ['h2', 'h3', 'h4', 'h5', 'p'], true) ? $headingTitleTag : 'h2';
?>
<div class="service-head section-heading<?= $headingCenter ? ' section-heading-center' : '' ?>">
    <div>
        <?php if (trim((string) $headingKicker) !== ''): ?>
            <span class="tiny-link"><?= e((string) $headingKicker) ?></span>
        <?php endif; ?>
        <?php echo '<' . $headingTitleTag . '>' . e((string) $headingTitle) . '</' . $headingTitleTag . '>'; ?>
    </div>
    <?php if (trim((string) $headingDescription) !== ''): ?>
        <p><?= e((string) $headingDescription) ?></p>
    <?php endif; ?>
    <?php if (trim((string) $headingActionText) !== '' && trim((string) $headingActionHref) !== ''): ?>
        <a class="news-link" href="<?= e((string) $headingActionHref) ?>"><?= e((string) $headingActionText) ?></a>
    <?php endif; ?>
</div>
