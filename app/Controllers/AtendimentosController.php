<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\TbAtendimento;

class AtendimentosController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('atendimentos.gerenciar');
        $atendimentos = TbAtendimento::all(['include' => ['cliente', 'profissional']]);
        $this->view('atendimentos/index', compact('atendimentos'));
    }
}
