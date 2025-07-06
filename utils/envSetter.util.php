<?php

require_once BASE_PATH . '/bootstrap.php';
require_once BASE_PATH . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

$databases = [
    'mongoHost' => $_ENV['MONGO_HOST'],
    'mongoPort' => $_ENV['MONGO_PORT'],
    'pgHost' => $_ENV['PG_HOST'],
    'pgPort' => $_ENV['PG_PORT'],
    'pgDB' => $_ENV['PG_DB'],
    'pgUser' => $_ENV['PG_USER'],
    'pgPass' => $_ENV['PG_PASS'],
];