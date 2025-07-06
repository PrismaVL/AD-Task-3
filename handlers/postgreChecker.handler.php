<?php

require_once __DIR__ . '/../utils/envSetter.util.php';

$host = $databases['pgHost'];
$port = $databases['pgPort'];
$dbname = $databases['pgDB'];
$user = $databases['pgUser'];
$password = $databases['pgPass'];

$conn_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";
$conn = pg_connect($conn_string);

if ($conn) {
    echo "✅ PostgreSQL Connection <br>";
} else {
    echo "❌ Connection Failed: " . pg_last_error() . "<br>";
}