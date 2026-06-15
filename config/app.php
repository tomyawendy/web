<?php

declare(strict_types=1);

return [
    'name' => 'Planet Aviation',
    'url' => getenv('APP_URL') ?: 'https://tanshan.lovestoblog.com',
    'locale' => 'en',
    'locales' => [
        'en' => 'English',
        'es' => 'Español',
    ],
    'admin_prefix' => 'backstage',
    'uploads' => [
        'images' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'],
        'documents' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'],
    ],
    'upload_max_bytes' => [
        'images' => 5242880,
        'documents' => 10485760,
    ],
];
