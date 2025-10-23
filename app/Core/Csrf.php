<?php

declare(strict_types=1);

namespace App\Core;

class Csrf
{
    public const SESSION_TOKEN = 'csrf_token';

    public static function token(): string
    {
        if (!isset($_SESSION[self::SESSION_TOKEN])) {
            $_SESSION[self::SESSION_TOKEN] = self::generateToken();
        }

        return $_SESSION[self::SESSION_TOKEN];
    }

    public static function regenerate(): string
    {
        $_SESSION[self::SESSION_TOKEN] = self::generateToken();
        return $_SESSION[self::SESSION_TOKEN];
    }

    public static function verify(?string $token): bool
    {
        if (!$token) {
            return false;
        }

        return hash_equals($_SESSION[self::SESSION_TOKEN] ?? '', $token);
    }

    private static function generateToken(): string
    {
        $secret = $_ENV['CSRF_SECRET'] ?? 'secret';
        return hash_hmac('sha256', bin2hex(random_bytes(16)), $secret);
    }
}
