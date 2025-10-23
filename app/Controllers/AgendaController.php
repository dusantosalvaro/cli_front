<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\TbAgendaEvento;

class AgendaController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('agenda.gerenciar');
        $this->view('agenda/index');
    }

    public function events(): void
    {
        $this->requirePermission('agenda.gerenciar');
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

        $this->json($payload);
    }
}
