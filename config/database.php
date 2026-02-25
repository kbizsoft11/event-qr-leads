<?php

$dsn = "mysql:host=localhost;dbname=test;charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, 'test', 'test', $options);
} catch (PDOException $e) {
    die("Database connection failed");
}