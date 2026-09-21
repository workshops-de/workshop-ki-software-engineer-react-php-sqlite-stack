<?php

declare(strict_types=1);

$dbPath = __DIR__ . '/bookmonkey.sqlite';
$schemaPath = __DIR__ . '/schema.sql';

$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$schema = file_get_contents($schemaPath);
$pdo->exec($schema);

echo "Migrated database at {$dbPath}\n";
