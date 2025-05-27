<?php

namespace Controllers;

class BaseController
{
    protected function view(string $viewName, array $data = []): void
    {
        extract($data);

        $viewPath = __DIR__ . '/../Views/' . $viewName . '.php';

        if (!file_exists($viewPath)) {
            throw new \Exception("View não encontrada: {$viewName}");
        }

        require $viewPath;
    }

    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function getQueryParam(string $name, $default = null)
    {
        return $_GET[$name] ?? $default;
    }

    protected function getPostParam(string $name, $default = null)
    {
        return $_POST[$name] ?? $default;
    }

    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
}
