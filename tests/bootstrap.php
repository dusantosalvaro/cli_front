<?php

declare(strict_types=1);

putenv('DB_CONNECTION=sqlite');
putenv('DB_DATABASE=:memory:');
putenv('SESSION_NAME=test_session');
putenv('CSRF_SECRET=test-secret');

$_ENV['DB_CONNECTION'] = 'sqlite';
$_ENV['DB_DATABASE'] = ':memory:';
$_ENV['SESSION_NAME'] = 'test_session';
$_ENV['CSRF_SECRET'] = 'test-secret';

require __DIR__ . '/../bootstrap/app.php';

use App\Services\DatabaseMigrator;
use App\Services\DatabaseSeeder;

$connection = \ActiveRecord\ConnectionManager::get_connection();
$pdo = $connection->connection;
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$migrator = new DatabaseMigrator($pdo);
$migrator->migrate();

$seeder = new DatabaseSeeder();
$seeder->seed();
