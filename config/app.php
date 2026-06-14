<?php

declare(strict_types=1);

return [
    'name' => 'Planet Aviation',
    'url' => getenv('APP_URL') ?: 'https://tanshan.lovestoblog.com',
    'locale' => 'en',
    'locales' => [
        'en' => 'English',
        'es' => 'Spanish',
        'zh' => 'Chinese',
    ],
    'admin_prefix' => 'backstage',
    'uploads' => [
        'images' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'],
        'documents' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'],
    ],
];
