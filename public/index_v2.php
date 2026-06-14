<?php

declare(strict_types=1);

$appRoot = is_dir(__DIR__ . '/app') ? __DIR__ : dirname(__DIR__);

require $appRoot . '/app/Support/helpers.php';

$db = require $appRoot . '/bootstrap/app.php';
$request = new \App\Core\Request();
$router = new \App\Core\Router();
$auth = new \App\Services\AuthService($db);
$logger = new \App\Services\ActivityLogService($db);

$middleware = [
    'auth' => function () use ($auth) {
        if (!$auth->check()) {
            redirect_with_flash(admin_url('login'), 'error', sign_in_required_message());
        }
        return true;
    },
    'guest' => function () use ($auth) {
        if ($auth->check()) {
            header('Location: ' . admin_url());
            exit;
        }
        return true;
    },
    'permission' => function (\App\Core\Request $request, ?string $permission) use ($auth) {
        if (!$auth->can((string) $permission)) {
            redirect_with_flash(admin_url(), 'error', permission_denied_message());
        }
        return true;
    },
];

require $appRoot . '/routes/web_v2.php';
require $appRoot . '/routes/admin.php';

$router->dispatch($request, $db, $middleware);
