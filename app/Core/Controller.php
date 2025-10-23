<?php

declare(strict_types=1);

namespace App\Core;

class Controller
{
    protected function view(string $template, array $data = []): void
    {
        View::render($template, $data);
    }

    protected function json(array $payload, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($payload);
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }

    protected function requirePermission(string ...$permissions): void
    {
        if (!Auth::authorize(...$permissions)) {
            http_response_code(403);
            throw new \RuntimeException('Acesso negado.');
        }
    }
}
