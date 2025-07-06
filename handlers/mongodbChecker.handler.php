<?php
try {

    require_once __DIR__ . '/../utils/envSetter.util.php';

    $mongoUri = $_ENV['MONGO_URI'];
    $mongoDb = $_ENV['MONGO_DB'];

    $mongo = new MongoDB\Driver\Manager("mongodb://host.docker.internal:27111");

    $command = new MongoDB\Driver\Command(["ping" => 1]);
    $mongo->executeCommand("admin", $command);

    echo "✅ Connected to MongoDB successfully.  <br>";
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "❌ MongoDB connection failed: " . $e->getMessage() . "  <br>";
}
