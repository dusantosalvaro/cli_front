<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;

class DashboardController extends Controller
{
    public function index(): void
    {
        $user = Auth::user();
        $this->view('dashboard/index', [
            'user' => $user,
        ]);
    }
}
