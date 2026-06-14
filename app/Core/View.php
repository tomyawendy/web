<?php

declare(strict_types=1);

namespace App\Core;

class View
{
    public static function render(string $template, array $data = [], ?string $layout = null): void
    {
        $templatePath = base_path('resources/views/' . $template . '.php');
        if (!file_exists($templatePath)) {
            http_response_code(500);
            echo 'The requested view could not be rendered.';
            return;
        }

        extract($data, EXTR_SKIP);
        ob_start();
        require $templatePath;
        $content = ob_get_clean();

        if ($layout === null) {
            echo $content;
            return;
        }

        $layoutPath = base_path('resources/views/' . $layout . '.php');
        if (!file_exists($layoutPath)) {
            http_response_code(500);
            echo 'The requested layout could not be rendered.';
            return;
        }

        require $layoutPath;
    }
}
