<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$pgConfig = [
    'host' => $_ENV['PG_HOST'],
    'port' => $_ENV['PG_PORT'],
    'db'   => $_ENV['PG_DB'],
    'user' => $_ENV['PG_USER'],
    'pass' => $_ENV['PG_PASS'],
];

$mongoConfig = [
    'uri' => $_ENV['MONGO_URI'],
    'db'  => $_ENV['MONGO_DB'],
];

// Optional: environment type logic
$typeConfig = [
    'key' => $_ENV['ENV_NAME'] ?? 'development',
];
