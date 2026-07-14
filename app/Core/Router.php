<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $route, array $action): void
    {
        $this->routes['GET'][$this->clean($route)] = $action;
    }

    public function post(string $route, array $action): void
    {
        $this->routes['POST'][$this->clean($route)] = $action;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Remove project folder when running on localhost
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);

        if ($scriptName !== '/') {
            $uri = substr($uri, strlen($scriptName));
        }

        $uri = $this->clean($uri);

        if (! isset($this->routes[$method][$uri])) {
            http_response_code(404);

            echo "<h1>404</h1>";
            echo "<p>Route not found.</p>";

            return;
        }

        [$controller, $action] = $this->routes[$method][$uri];

        $controller = new $controller();

        $controller->$action();
    }

    private function clean(string $uri): string
    {
        $uri = trim($uri, '/');

        return $uri === '' ? '/' : $uri;
    }
}