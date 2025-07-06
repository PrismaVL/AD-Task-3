<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';
require_once 'bootstrap.php';
require_once UTILS_PATH . '/envSetter.util.php';

$dsn = "pgsql:host={$databases['pgHost']};port={$databases['pgPort']};dbname={$databases['pgDB']}";
$pdo = new PDO($dsn, $databases['pgUser'], $databases['pgPass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);
echo "✅ Connected to PostgreSQL.\n";

echo "Dropping old tables…\n";
foreach ([
  'project_users',
  'tasks',
  'projects',
  'users',
] as $table) {
    
  $pdo->exec("DROP TABLE IF EXISTS {$table} CASCADE;");
}

echo "Applying schema from database/users.model.sql…\n";
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
    echo "Creation Success from the database/{$model}\n";
}

echo "✅ PostgreSQL migration complete!\n";