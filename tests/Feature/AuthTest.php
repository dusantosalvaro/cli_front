<?php

declare(strict_types=1);

use App\Core\Auth;
use App\Core\Csrf;
use App\Models\TbUser;

final class AuthTest extends PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        session_id('phpunit');
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        TbUser::delete_all(['conditions' => ['email = ?', 'teste@example.com']]);

        TbUser::create([
            'name' => 'Teste',
            'email' => 'teste@example.com',
            'password_hash' => password_hash('senha', PASSWORD_BCRYPT),
            'role' => 'admin',
            'permissions' => 'agenda.gerenciar',
        ]);
    }

    public function testCsrfTokenValidation(): void
    {
        $token = Csrf::token();
        self::assertTrue(Csrf::verify($token));
        self::assertFalse(Csrf::verify('token-invalido'));
    }

    public function testAttemptAuthWithValidCredentials(): void
    {
        $result = Auth::attempt('teste@example.com', 'senha');
        self::assertTrue($result);
        self::assertNotNull(Auth::user());
    }

    public function testAttemptAuthWithInvalidPassword(): void
    {
        $result = Auth::attempt('teste@example.com', 'errado');
        self::assertFalse($result);
        self::assertNull(Auth::user());
    }
}
