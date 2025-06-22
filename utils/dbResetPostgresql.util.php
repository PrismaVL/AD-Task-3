<?php
declare(strict_types=1);

require 'vendor/autoload.php';
require 'bootstrap.php';
require_once __DIR__ . '/envSetter.util.php';

// --- Connect to PostgreSQL ---
$dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['db']}";
$pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['pass'], [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

echo "Connected to PostgreSQL.\n";

// --- Truncate existing tables ---
echo "Truncating tables...\n";
foreach (['project_users', 'tasks', 'projects', 'users'] as $table) {
  $pdo->exec("DROP TABLE IF EXISTS {$table} CASCADE;");
}

// --- Recreate tables ---
foreach (['users', 'projects', 'tasks', 'project_users'] as $table) {
    $path = __DIR__ . "/../database/{$table}.model.sql";
    echo "Applying schema for {$table}...\n";
    $sql = file_get_contents($path);

    if ($sql === false) {
        throw new RuntimeException("❌ Could not read {$path}");
    }

    $pdo->exec($sql);
    echo "✅ Created table: {$table}\n";
}
