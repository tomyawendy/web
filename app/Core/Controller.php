<?php

declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected Request $request;
    protected Database $db;

    public function __construct(Request $request, Database $db)
    {
        $this->request = $request;
        $this->db = $db;
    }

    protected function view(string $template, array $data = [], ?string $layout = null): void
    {
        View::render($template, $data, $layout);
    }

    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }
}
