<?php
require '../config/database.php';

$stmt = $pdo->prepare("
    INSERT INTO leads
    (event_id, first_name, surname, company, email, phone, notes)
    VALUES
    (:event_id, :first_name, :surname, :company, :email, :phone, :notes)
");

$stmt->execute([
    ':event_id' => (int)$_POST['event_id'],
    ':first_name' => trim($_POST['first_name']),
    ':surname' => trim($_POST['surname']),
    ':company' => trim($_POST['company']),
    ':email' => trim($_POST['email']),
    ':phone' => trim($_POST['phone']),
    ':notes' => trim($_POST['notes'])
]);

header("Location: success.php?event_id=".$_POST['event_id']);
exit;