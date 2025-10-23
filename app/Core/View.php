<?php

declare(strict_types=1);

namespace App\Core;

class View
{
    public static function render(string $template, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $templatePath = __DIR__ . '/../Views/' . $template . '.php';

        if (!file_exists($templatePath)) {
            throw new \RuntimeException(sprintf('View "%s" não encontrada.', $template));
        }

        include __DIR__ . '/../Views/layouts/header.php';
        include $templatePath;
        include __DIR__ . '/../Views/layouts/footer.php';
    }

    public static function renderPartial(string $template, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $templatePath = __DIR__ . '/../Views/' . $template . '.php';

        if (!file_exists($templatePath)) {
            throw new \RuntimeException(sprintf('View "%s" não encontrada.', $template));
        }

        include $templatePath;
    }
}
