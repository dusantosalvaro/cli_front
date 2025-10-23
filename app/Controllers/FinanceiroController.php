<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\TbLancamento;

class FinanceiroController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('financeiro.gerenciar');
        $lancamentos = TbLancamento::all();
        $this->view('financeiro/index', compact('lancamentos'));
    }
}
