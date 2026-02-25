<?php
require '../includes/auth.php';
require '../config/database.php';

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM leads WHERE id = ?");
$stmt->execute([$id]);

header("Location: leads.php?deleted=1");
exit;