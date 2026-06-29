<?php
declare(strict_types=1);

class Router
{
    private array $routes = [];

    public function get(string $path, string $controller, string $action): void
    {
        $this->routes['GET'][$path] = compact('controller', 'action');
    }

    public function post(string $path, string $controller, string $action): void
    {
        $this->routes['POST'][$path] = compact('controller', 'action');
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if ($uri !== '/') {
            $uri = rtrim($uri, '/');
        }

        if (isset($this->routes[$method][$uri])) {
            ['controller' => $ctrl, 'action' => $action] = $this->routes[$method][$uri];
            $instance = new $ctrl();
            $instance->$action();
            return;
        }

        http_response_code(404);
        include VIEWS_PATH . '/404.php';
    }
}
