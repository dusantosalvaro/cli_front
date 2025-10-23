<?php

declare(strict_types=1);

namespace App\Core;

use App\Models\TbUser;

class Auth
{
    public const SESSION_USER = 'auth_user_id';

    public static function attempt(string $email, string $password): bool
    {
        $user = TbUser::find_by_email($email);
        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user->password_hash)) {
            return false;
        }

        $_SESSION[self::SESSION_USER] = $user->id;
        return true;
    }

    public static function user(): ?TbUser
    {
        if (!isset($_SESSION[self::SESSION_USER])) {
            return null;
        }

        return TbUser::find($_SESSION[self::SESSION_USER]) ?: null;
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function logout(): void
    {
        unset($_SESSION[self::SESSION_USER]);
    }

    public static function authorize(string ...$permissions): bool
    {
        $user = self::user();
        if (!$user) {
            return false;
        }

        $userPermissions = $user->permissions_list;
        foreach ($permissions as $permission) {
            if (!in_array($permission, $userPermissions, true)) {
                return false;
            }
        }

        return true;
    }
}
