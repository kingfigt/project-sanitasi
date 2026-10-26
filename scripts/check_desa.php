<?php
$path = __DIR__ . '/../.env';
$dotenv = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($dotenv as $line) {
    $line = trim($line);
    if ($line === '' || strpos($line, '#') === 0) continue;
    putenv($line);
}
$dsn = sprintf('mysql:host=%s;port=%s;dbname=%s', getenv('DB_HOST'), getenv('DB_PORT'), getenv('DB_DATABASE'));
$pdo = new PDO($dsn, getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
$stmt = $pdo->query('SELECT COUNT(*) AS c FROM desa');
$c = $stmt->fetch(PDO::FETCH_ASSOC);
echo 'desa count: ' . ($c['c'] ?? '0') . PHP_EOL;
$stmt2 = $pdo->query('SELECT id_desa, kelurahan, rw, rt FROM desa LIMIT 5');
$rows = $stmt2->fetchAll(PDO::FETCH_ASSOC);
print_r($rows);
