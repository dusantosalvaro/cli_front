<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;

class AuthController extends Controller
{
    public function showLogin(): void
    {
        $this->view('auth/login', [
            'csrfToken' => Csrf::token(),
            'error' => $_SESSION['login_error'] ?? null,
        ]);
        unset($_SESSION['login_error']);
    }

    public function login(): void
    {
        if (!Csrf::verify($_POST['csrf_token'] ?? null)) {
            $_SESSION['login_error'] = 'Token CSRF inválido.';
            $this->redirect('/login');
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!Auth::attempt($email, $password)) {
            $_SESSION['login_error'] = 'Credenciais inválidas.';
            $this->redirect('/login');
        }

        Csrf::regenerate();
        $this->redirect('/');
    }

    public function logout(): void
    {
        Auth::logout();
        Csrf::regenerate();
        $this->redirect('/login');
    }
}
