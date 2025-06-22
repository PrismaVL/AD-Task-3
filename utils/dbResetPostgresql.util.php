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

echo "✅ Connected to PostgreSQL.\n";

// --- Drop existing tables (in reverse dependency order) ---
echo "🔁 Dropping tables if they exist...\n";
foreach (['project_users', 'tasks', 'projects', 'users'] as $table) {
  $pdo->exec("DROP TABLE IF EXISTS {$table} CASCADE;");
  echo "🗑️  Dropped table: {$table}\n";
}

// --- Recreate tables from model files ---
echo "🔨 Rebuilding tables from model files...\n";

$models = [
  'users.model.sql'          => 'users',
  'project.model.sql'        => 'projects',
  'task.model.sql'           => 'tasks',
  'project_users.model.sql'  => 'project_users',
];

foreach ($models as $filename => $tableName) {
  $path = __DIR__ . "/../database/{$filename}";
  echo "📄 Applying schema for {$tableName}...\n";

  $sql = file_get_contents($path);
  if ($sql === false) {
    throw new RuntimeException("❌ Could not read {$path}");
  }

  $pdo->exec($sql);
  echo "✅ Created table: {$tableName}\n";
}

// --- Truncate tables (now that they exist) ---
echo "🧼 Truncating tables...\n";
foreach (['project_users', 'tasks', 'projects', 'users'] as $table) {
  $pdo->exec("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE;");
  echo "🔁 Truncated table: {$table}\n";
}
