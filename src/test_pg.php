<?php

$host = getenv('POSTGRES_HOST') ?: 'db';
$db   = getenv('POSTGRES_DB');
$user = getenv('POSTGRES_USER');
$pass = getenv('POSTGRES_PASSWORD');

$dsn = "pgsql:host=$host;port=5432;dbname=$db;";
try {
    $pdo = new PDO($dsn, $user, $pass);
    echo "Conexão com PostgreSQL OK";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
