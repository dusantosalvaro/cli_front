<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\TbUser;
use App\Models\TbCliente;
use App\Models\TbAgendaEvento;
use DateInterval;
use DateTimeImmutable;

class DatabaseSeeder
{
    public function seed(): void
    {
        if (!TbUser::count()) {
            TbUser::create([
                'name' => 'Administrador',
                'email' => 'admin@example.com',
                'password_hash' => password_hash('secret', PASSWORD_BCRYPT),
                'role' => 'admin',
                'permissions' => 'clientes.gerenciar,anamneses.gerenciar,atendimentos.gerenciar,agenda.gerenciar,financeiro.gerenciar,administracao.gerenciar'
            ]);
        }

        if (!TbCliente::count()) {
            $cliente = TbCliente::create([
                'nome' => 'Cliente Exemplo',
                'email' => 'cliente@example.com',
                'telefone' => '(11) 99999-0000',
            ]);

            $agora = new DateTimeImmutable('now');
            $eventoInicio = $agora->add(new DateInterval('P1D'));
            $eventoFim = $eventoInicio->add(new DateInterval('PT1H'));

            TbAgendaEvento::create([
                'titulo' => 'Consulta Inicial',
                'inicio' => $eventoInicio->format(DateTimeImmutable::ATOM),
                'fim' => $eventoFim->format(DateTimeImmutable::ATOM),
                'cliente_id' => $cliente->id,
            ]);
        }
    }
}
