<?php
require '../config/database.php';
require '../includes/auth.php';
require '../includes/functions.php';
include '../phpqrcode/qrlib.php';

$event_id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$event_id]);

$event = $stmt->fetch();

if (!$event) {
    die("Event not found");
}

/* URL for form */
$formUrl = base_url()."/public/form.php?event_id=".$event_id;

/* Save path */
$filename = "../qrcodes/event_".$event_id.".png";

/* Create folder if missing */
if (!file_exists('../qrcodes')) {
    mkdir('../qrcodes', 0777, true);
}

/* Generate QR */
QRcode::png($formUrl, $filename, QR_ECLEVEL_L, 6);

echo "<h3>QR Generated</h3>";
echo "<img src='../qrcodes/event_".$event_id.".png'>";