<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\TbCliente;

class ClientesController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('clientes.gerenciar');
        $clientes = TbCliente::all();
        $this->view('clientes/index', compact('clientes'));
    }
}
