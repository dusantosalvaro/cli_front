<?php

declare(strict_types=1);

$rootPath = require __DIR__ . '/../bootstrap/app.php';

use App\Controllers\AdministracaoController;
use App\Controllers\AgendaController;
use App\Controllers\AnamnesesController;
use App\Controllers\AtendimentosController;
use App\Controllers\AuthController;
use App\Controllers\ClientesController;
use App\Controllers\DashboardController;
use App\Controllers\FinanceiroController;
use App\Core\Auth;
use App\Services\DatabaseMigrator;
use App\Services\DatabaseSeeder;
use Bramus\Router\Router;

$pdo = new PDO('sqlite:' . $rootPath . '/storage/database.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$migrator = new DatabaseMigrator($pdo);
$migrator->migrate();

$seeder = new DatabaseSeeder();
$seeder->seed();

$router = new Router();

$router->before('GET|POST', '/.*', function () {
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $publicRoutes = ['/login', '/logout'];

    if (in_array($path, $publicRoutes, true)) {
        return;
    }

    if (!Auth::check()) {
        header('Location: /login');
        exit;
    }
});

$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/', [DashboardController::class, 'index']);
$router->get('/clientes', [ClientesController::class, 'index']);
$router->get('/anamneses', [AnamnesesController::class, 'index']);
$router->get('/atendimentos', [AtendimentosController::class, 'index']);
$router->get('/agenda', [AgendaController::class, 'index']);
$router->get('/agenda/eventos', [AgendaController::class, 'events']);
$router->get('/financeiro', [FinanceiroController::class, 'index']);
$router->get('/administracao', [AdministracaoController::class, 'index']);

$router->run();
