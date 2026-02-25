<?php
require 'database.php';

$username = 'admin';
$password = password_hash('admin!@##@!123', PASSWORD_DEFAULT);

$stmt = $pdo->prepare("
    INSERT INTO admins (username, password)
    VALUES (:username, :password)
");

$stmt->execute([
    ':username' => $username,
    ':password' => $password
]);

echo "Admin created — delete this file now.";