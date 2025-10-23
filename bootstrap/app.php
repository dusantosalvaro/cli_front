<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use ActiveRecord\Config as ARConfig;

require_once __DIR__ . '/../vendor/autoload.php';

$rootPath = realpath(__DIR__ . '/..');

if (file_exists($rootPath . '/.env')) {
    $dotenv = Dotenv::createImmutable($rootPath);
    $dotenv->safeLoad();
}

session_name($_ENV['SESSION_NAME'] ?? 'app_session');
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$connection = $_ENV['DB_CONNECTION'] ?? 'sqlite';
$dbPath = $_ENV['DB_DATABASE'] ?? $rootPath . '/storage/database.sqlite';

if ($connection === 'sqlite' && strpos($dbPath, DIRECTORY_SEPARATOR) !== 0) {
    $dbPath = $rootPath . '/' . $dbPath;
}

ARConfig::initialize(function (ARConfig $cfg) use ($connection, $dbPath) {
    if ($connection === 'sqlite') {
        $cfg->set_connections([
            'development' => 'sqlite://' . $dbPath,
        ]);
    } else {
        $username = $_ENV['DB_USERNAME'] ?? 'root';
        $password = $_ENV['DB_PASSWORD'] ?? '';
        $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
        $database = $_ENV['DB_DATABASE'] ?? 'app';
        $cfg->set_connections([
            'development' => sprintf('%s://%s:%s@%s/%s', $connection, $username, $password, $host, $database),
        ]);
    }

    $cfg->set_default_connection('development');
    $cfg->set_model_directory(__DIR__ . '/../app/Models');
});

return $rootPath;
