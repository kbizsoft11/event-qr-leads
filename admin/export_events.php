<?php
require '../includes/auth.php';
require '../config/database.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=events_export.xls");

echo "Event Name\tLocation\tDate\tDescription\n";

$stmt = $pdo->query("SELECT name, location, event_date, description FROM events ORDER BY id DESC");

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    echo
        $row['name']."\t".
        $row['location']."\t".
        $row['event_date']."\t".
        str_replace("\n"," ",$row['description'])."\n";
}
exit;