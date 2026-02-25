<?php
require '../includes/auth.php';
require '../config/database.php';
require '../includes/functions.php';
include '../includes/header.php';

$limit = 15;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);

$offset = ($page - 1) * $limit;

/* Fetch events for dropdown */
$eventsList = $pdo->query("SELECT id, name FROM events ORDER BY name")->fetchAll();

/* Filter */
$eventFilter = $_GET['event_id'] ?? '';

$where = "";
$params = [];

if (!empty($eventFilter)) {
    $where = "WHERE l.event_id = :event_id";
    $params[':event_id'] = $eventFilter;
}

/* Count */
$countSql = "SELECT COUNT(*) FROM leads l $where";
$countStmt = $pdo->prepare($countSql);
$countStmt->execute($params);
$total = $countStmt->fetchColumn();
$totalPages = ceil($total / $limit);

/* Leads query */
$sql = "
SELECT l.*, e.name event_name
FROM leads l
LEFT JOIN events e ON l.event_id = e.id
$where
ORDER BY l.created_at DESC
LIMIT :limit OFFSET :offset
";

$stmt = $pdo->prepare($sql);

foreach ($params as $key => $val) {
    $stmt->bindValue($key, $val);
}

$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();

$leads = $stmt->fetchAll();
?>

<div class="page-header">

<div>
<div class="page-title">Leads</div>
<div class="page-subtitle">Manage captured event leads</div>
</div>

<div>
<a href="export_leads.php?event_id=<?php echo $eventFilter;?>" class="btn btn-outline-secondary">
📥 Export All Leads
</a>
</div>

</div>

<!-- FILTER -->
<form method="get" class="mb-3">

<div class="row g-2 align-items-end">

<div class="col-md-4">
<label class="form-label">Filter by Event</label>

<select name="event_id" class="form-select">
<option value="">All Events</option>

<?php foreach ($eventsList as $ev): ?>
<option value="<?= $ev['id'] ?>"
<?= $eventFilter == $ev['id'] ? 'selected' : '' ?>>
<?= htmlspecialchars($ev['name']) ?>
</option>
<?php endforeach; ?>

</select>
</div>

<div class="col-md-3">
<button class="btn btn-primary">Apply</button>
<a href="leads.php" class="btn btn-outline-secondary">Clear</a>
</div>

</div>

</form>

<div class="card shadow-sm">
<div class="card-body">

<?php if (!empty($leads)): ?>

<div class="table-responsive">
<table class="table align-middle">

<thead>
<tr>
<th>Date</th>
<th>Event</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php foreach ($leads as $lead): ?>
<tr>

<td><?= date('d M Y', strtotime($lead['created_at'])); ?></td>
<td><?= htmlspecialchars($lead['event_name']) ?></td>
<td><?= htmlspecialchars($lead['first_name'].' '.$lead['surname']) ?></td>
<td><?= htmlspecialchars($lead['email']) ?></td>
<td><?= htmlspecialchars($lead['phone']) ?></td>

<td>
<a href="delete_lead.php?id=<?= $lead['id'] ?>"
   class="btn btn-sm btn-outline-danger"
   onclick="return confirm('Are you sure want to delete lead?')">
Delete
</a>
</td>

</tr>
<?php endforeach; ?>

</tbody>
</table>
</div>

<nav>
<ul class="pagination justify-content-center">

<?php if ($page > 1): ?>
<li class="page-item">
<a class="page-link" href="?page=<?= $page-1 ?>&event_id=<?= urlencode($eventFilter) ?>">Previous</a>
</li>
<?php endif; ?>

<?php for ($i=1; $i <= $totalPages; $i++): ?>
<li class="page-item <?= $i==$page?'active':'' ?>">
<a class="page-link" href="?page=<?= $i ?>&event_id=<?= urlencode($eventFilter) ?>">
<?= $i ?>
</a>
</li>
<?php endfor; ?>

<?php if ($page < $totalPages): ?>
<li class="page-item">
<a class="page-link" href="?page=<?= $page+1 ?>&event_id=<?= urlencode($eventFilter) ?>">Next</a>
</li>
<?php endif; ?>

</ul>
</nav>

<?php else: ?>

<div class="empty-state">
<h5>No leads yet</h5>
<p>Leads will appear here after users register.</p>
</div>

<?php endif; ?>

</div>
</div>

<?php include '../includes/footer.php'; ?>