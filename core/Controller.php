<?php
declare(strict_types=1);

class Controller
{
    protected function render(string $view, array $data = [], string $layout = 'main'): void
    {
        extract($data, EXTR_SKIP);

        ob_start();
        $viewFile = VIEWS_PATH . '/' . $view . '.php';
        if (file_exists($viewFile)) {
            include $viewFile;
        }
        $content = ob_get_clean();

        $layoutFile = VIEWS_PATH . '/layouts/' . $layout . '.php';
        if (file_exists($layoutFile)) {
            include $layoutFile;
        }
    }

    protected function json(mixed $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
