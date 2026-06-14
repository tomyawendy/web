<?php
$regions = setting_lines($settings, 'world_regions');
$partners = setting_media_pairs($settings, 'partners_logos');
if ($partners === []) {
    $partners = [
        ['label' => 'MNG Airlines', 'path' => 'assets/figma/partner-1.png'],
        ['label' => 'Hainan Airlines', 'path' => 'assets/figma/partner-2.png'],
        ['label' => 'Capital Airlines', 'path' => 'assets/figma/partner-3.png'],
        ['label' => 'China Southern', 'path' => 'assets/figma/partner-4.png'],
        ['label' => 'BAC', 'path' => 'assets/figma/partner-5.png'],
    ];
}
?>
<?php include base_path('resources/views/public/sections/hero.php'); ?>
<?php include base_path('resources/views/public/sections/lookup.php'); ?>
<?php include base_path('resources/views/public/sections/about.php'); ?>
<?php include base_path('resources/views/public/sections/services.php'); ?>
<?php include base_path('resources/views/public/sections/why.php'); ?>
<?php include base_path('resources/views/public/sections/world.php'); ?>
<?php include base_path('resources/views/public/sections/partners.php'); ?>
<?php include base_path('resources/views/public/sections/news.php'); ?>
<?php include base_path('resources/views/public/partials/contact_block.php'); ?>
<?php include base_path('resources/views/public/partials/newsletter.php'); ?>
