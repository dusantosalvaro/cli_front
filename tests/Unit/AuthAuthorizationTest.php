<?php

declare(strict_types=1);

use App\Core\Auth;
use App\Models\TbUser;

final class AuthAuthorizationTest extends PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        session_id('authorization');
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        TbUser::delete_all(['conditions' => ['email = ?', 'permissoes@example.com']]);

        TbUser::create([
            'name' => 'Permissões',
            'email' => 'permissoes@example.com',
            'password_hash' => password_hash('senha', PASSWORD_BCRYPT),
            'permissions' => 'clientes.gerenciar,agenda.gerenciar'
        ]);
    }

    public function testAuthorizeRetornaTrueQuandoPermissoesSaoValidas(): void
    {
        Auth::attempt('permissoes@example.com', 'senha');
        self::assertTrue(Auth::authorize('clientes.gerenciar'));
        self::assertTrue(Auth::authorize('agenda.gerenciar'));
    }

    public function testAuthorizeRetornaFalseQuandoPermissaoNaoExiste(): void
    {
        Auth::attempt('permissoes@example.com', 'senha');
        self::assertFalse(Auth::authorize('financeiro.gerenciar'));
    }
}
