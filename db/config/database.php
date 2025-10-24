<?php

use ActiveRecord\Config as ARConfig;
use ActiveRecord\ConfigException;

if (!class_exists(ARConfig::class)) {
    throw new RuntimeException('ActiveRecord library not loaded. Ensure Composer dependencies are installed before bootstrapping the database connection.');
}

$environment = getenv('APP_ENV') ?: 'development';
$dbName = getenv('DB_NAME') ?: 'clinic_app';
$dbUser = getenv('DB_USER') ?: 'root';
$dbPassword = getenv('DB_PASSWORD') ?: '';
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbPort = getenv('DB_PORT') ?: '3306';
$dbCharset = getenv('DB_CHARSET') ?: 'utf8mb4';

$connectionUrl = sprintf(
    'mysql://%s:%s@%s:%s/%s?charset=%s',
    rawurlencode($dbUser),
    rawurlencode($dbPassword),
    $dbHost,
    $dbPort,
    $dbName,
    $dbCharset
);

$registerConnection = static function (ARConfig $config) use ($connectionUrl, $environment) {
    $config->set_connections([
        $environment => $connectionUrl,
    ]);
    $config->set_default_connection($environment);
};

try {
    $config = ARConfig::instance();
    $registerConnection($config);
} catch (ConfigException $exception) {
    ARConfig::initialize($registerConnection);
}
