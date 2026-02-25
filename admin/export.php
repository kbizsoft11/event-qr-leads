<?php
require '../config/database.php';
require '../includes/functions.php';
include '../includes/header.php';
require '../includes/auth.php';

$sql = "
SELECT l.*, e.name AS event_name
FROM leads l
LEFT JOIN events e ON l.event_id = e.id
ORDER BY l.created_at DESC
";

$leads = $pdo->query($sql)->fetchAll();
?>