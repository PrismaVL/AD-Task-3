<?php

try {
    require_once __DIR__ . '/../utils/envSetter.util.php';

    $host = $databases['mongoHost'];
    $port = $databases['mongoPort'];

    $mongo = new MongoDB\Driver\Manager("mongodb://$host:$port");

    $command = new MongoDB\Driver\Command(["ping" => 1]);
    $mongo->executeCommand("admin", $command);

    echo "✅ Connected to MongoDB successfully. <br>";
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "❌ MongoDB connection failed: " . $e->getMessage() . "<br>";
}