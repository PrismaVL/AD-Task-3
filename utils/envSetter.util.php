<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$typeConfig = [
    'key' => $_ENV['ENV_NAME'] ?? 'development',
];
