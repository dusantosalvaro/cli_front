<?php

declare(strict_types=1);

use App\Models\TbAgendaEvento;
use App\Models\TbCliente;
use App\Models\TbUser;

final class AgendaApiTest extends PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        session_id('agenda');
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        TbUser::delete_all(['conditions' => ['email = ?', 'agenda@example.com']]);
        TbCliente::delete_all(['conditions' => ['nome = ?', 'Paciente Agenda']]);
        TbAgendaEvento::delete_all(['conditions' => ['titulo = ?', 'Retorno']]);

        TbUser::create([
            'name' => 'Agenda User',
            'email' => 'agenda@example.com',
            'password_hash' => password_hash('senha', PASSWORD_BCRYPT),
            'role' => 'admin',
            'permissions' => 'agenda.gerenciar',
        ]);

        $cliente = TbCliente::create([
            'nome' => 'Paciente Agenda',
        ]);

        TbAgendaEvento::create([
            'titulo' => 'Retorno',
            'inicio' => '2024-01-01T08:00:00-03:00',
            'fim' => '2024-01-01T09:00:00-03:00',
            'cliente_id' => $cliente->id,
        ]);
    }

    public function testEventosSaoSerializadosComoJson(): void
    {
        $eventos = TbAgendaEvento::all();
        $payload = array_map(static function (TbAgendaEvento $evento) {
            return [
                'id' => $evento->id,
                'title' => $evento->titulo,
                'start' => $evento->inicio,
                'end' => $evento->fim,
                'clienteId' => $evento->cliente_id,
            ];
        }, $eventos);

        self::assertSame('Retorno', $payload[0]['title']);
        self::assertSame('2024-01-01T08:00:00-03:00', $payload[0]['start']);
    }
}
