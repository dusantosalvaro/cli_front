<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\TbAnamnese;

class AnamnesesController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('anamneses.gerenciar');
        $anamneses = TbAnamnese::all(['include' => ['cliente']]);
        $this->view('anamneses/index', compact('anamneses'));
    }
}
