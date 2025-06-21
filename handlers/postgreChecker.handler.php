<?php
require_once __DIR__ . '/../utils/envSetter.util.php';

$pgHost = $_ENV['PG_HOST'];
$pgPort = $_ENV['PG_PORT'];
$pgDb   = $_ENV['PG_DB'];
$pgUser = $_ENV['PG_USER'];
$pgPass = $_ENV['PG_PASS'];

$conn_string = "host=$pgHost port=$pgPort dbname=$pgDb user=$pgUser password=$pgPass";

$conn = pg_connect($conn_string);

if ($conn) {
    echo "✅ PostgreSQL Connection <br>";
} else {
    echo "❌ Connection Failed: " . pg_last_error() . "<br>";
}
