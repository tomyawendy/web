<?php

declare(strict_types=1);

namespace App\Core;

use App\Repositories\SettingRepository;
use Closure;

class Router
{
    private array $routes = [];

    public function get(string $path, $handler, array $middleware = []): void
    {
        $this->add('GET', $path, $handler, $middleware);
    }

    public function post(string $path, $handler, array $middleware = []): void
    {
        $this->add('POST', $path, $handler, $middleware);
    }

    private function add(string $method, string $path, $handler, array $middleware): void
    {
        $this->routes[$method][] = [
            'path' => '/' . trim($path, '/'),
            'handler' => $handler,
            'middleware' => $middleware,
        ];
    }

    public function dispatch(Request $request, Database $db, array $middlewareMap): void
    {
        $path = $request->path();
        $method = $request->method();
        $routes = $this->routes[$method] ?? [];

        foreach ($routes as $route) {
            $pattern = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_-]*)\}#', '([^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if (!preg_match($pattern, $path, $matches)) {
                continue;
            }

            array_shift($matches);
            foreach ($route['middleware'] as $middleware) {
                $name = $middleware;
                $parameter = null;
                if (str_contains($middleware, ':')) {
                    [$name, $parameter] = explode(':', $middleware, 2);
                }

                $callable = $middlewareMap[$name] ?? null;
                if ($callable instanceof Closure) {
                    $result = $callable($request, $parameter);
                    if ($result === false) {
                        return;
                    }
                }
            }

            $handler = $route['handler'];
            if ($handler instanceof Closure) {
                $handler(...$matches);
                return;
            }

            [$class, $action] = $handler;
            $controller = new $class($request, $db);
            $controller->{$action}(...$matches);
            return;
        }

        http_response_code(404);

        $settings = (new SettingRepository($db))->allGrouped()[current_locale()] ?? [];
        View::render('public/not_found', [
            'title' => site_name($settings),
            'message' => $settings['page_not_found_message'] ?? 'The requested page is not available.',
            'settings' => $settings,
            'metaTitle' => site_meta_title($settings),
        ], 'layouts/public');
    }
}
