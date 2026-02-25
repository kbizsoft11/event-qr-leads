<?php
require '../includes/auth.php';
require '../config/database.php';

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
$stmt->execute([$id]);

header("Location: events.php");
exit;