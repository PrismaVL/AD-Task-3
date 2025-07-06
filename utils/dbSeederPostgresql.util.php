<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';
require_once 'bootstrap.php';
require_once UTILS_PATH . '/envSetter.util.php';

$users = require_once STATIC_DATA_PATH . '/users.staticData.php';

$dsn = "pgsql:host={$databases['pgHost']};port={$databases['pgPort']};dbname={$databases['pgDB']}";
$pdo = new PDO($dsn, $databases['pgUser'], $databases['pgPass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);
echo "✅ Connected to PostgreSQL.\n";


echo "🧼 Truncating tables…\n";
foreach (['project_users', 'tasks', 'projects', 'users'] as $table) {
  $pdo->exec("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE;");
}

echo "🔨 Applying schema from model files…\n";
$models = [
    'users.model.sql',
    'project.model.sql',
    'task.model.sql',
    'project_users.model.sql',
];

foreach ($models as $model) {
    $sql = file_get_contents(BASE_PATH . '/database/' . $model);
    if ($sql === false) {
        throw new RuntimeException("Could not read database/{$model}");
    }
    $pdo->exec($sql);
    echo "📄 Applied schema from {$model}\n";
}

echo "Seeding users…\n";

$stmt = $pdo->prepare("
    INSERT INTO users (username, role, first_name, last_name, password)
    VALUES (:username, :role, :fn, :ln, :pw)
");

foreach ($users as $u) {
  $stmt->execute([
    ':username' => $u['username'],
    ':role' => $u['role'],
    ':fn' => $u['first_name'],
    ':ln' => $u['last_name'],
    ':pw' => password_hash($u['password'], PASSWORD_DEFAULT),
  ]);
}

echo "✅ PostgreSQL seeding complete!\n";