<?php
require '../includes/auth.php';
require '../config/database.php';

$eventFilter = $_GET['event_id'] ?? '';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=leads_export.xls");

echo "Date\tEvent\tName\tEmail\tPhone\n";

$where = "";
$params = [];

if (!empty($eventFilter)) {
    $where = "WHERE l.event_id = :event_id";
    $params[':event_id'] = $eventFilter;
}

$sql = "
SELECT l.created_at, e.name, l.first_name, l.surname, l.email, l.phone
FROM leads l
LEFT JOIN events e ON l.event_id = e.id
$where
ORDER BY l.created_at DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    echo
        $row['created_at']."\t".
        $row['name']."\t".
        $row['first_name']." ".$row['surname']."\t".
        $row['email']."\t".
        $row['phone']."\n";
}

exit;