<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\TbUser;

class AdministracaoController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('administracao.gerenciar');
        $usuarios = TbUser::all();
        $this->view('administracao/index', compact('usuarios'));
    }
}
