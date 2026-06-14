<?php

declare(strict_types=1);

session_start();

require_once base_path('app/Support/helpers.php');

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }

    $path = base_path('app/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php');
    if (file_exists($path)) {
        require $path;
    }
});

set_locale($_GET['lang'] ?? current_locale());

return new \App\Core\Database(config('database'));
