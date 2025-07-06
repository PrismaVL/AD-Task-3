<?php

$host = "host.docker.internal";
$port = "5432";
$dbname = "prismadatabase";
$user = "user";
$password = "password";

$conn_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";

$conn = pg_connect($conn_string);

if ($conn) {
    echo "✅ PostgreSQL Connection <br>";
} else {
    echo "❌ Connection Failed: " . pg_last_error() . "<br>";
}