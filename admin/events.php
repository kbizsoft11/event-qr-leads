<?php
require '../config/database.php';
require '../includes/functions.php';
require '../includes/auth.php';
include '../includes/header.php';

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);

$search = $_GET['search'] ?? '';
$searchParam = "%$search%";

$offset = ($page - 1) * $limit;

/* Count total with filter */
$countSql = "SELECT COUNT(*) FROM events";
if (!empty($search)) {
    $countSql .= " WHERE name LIKE :search";
}

$countStmt = $pdo->prepare($countSql);
if (!empty($search)) {
    $countStmt->bindValue(':search', $searchParam);
}
$countStmt->execute();

$total = $countStmt->fetchColumn();
$totalPages = ceil($total / $limit);

/* Fetch events */
$sql = "SELECT * FROM events";
if (!empty($search)) {
    $sql .= " WHERE name LIKE :search";
}
$sql .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($sql);

if (!empty($search)) {
    $stmt->bindValue(':search', $searchParam);
}

$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$events = $stmt->fetchAll();

?>



<link href="assets/css/events.css" rel="stylesheet">

<div class="page-header">

	<div>
		<div class="page-title">Events</div>
		<div class="page-subtitle">Manage your event listings</div>
	</div>

	<div class="d-flex gap-2">
		<a href="add_event.php" class="btn btn-primary">+ Add Event</a>

		<a href="export_events.php" class="btn btn-outline-secondary">
			Export All Events
		</a>
	</div>

</div>

<div class="card shadow-sm">

	<form method="GET" class="mb-3">
		<div style="display:flex; gap:10px; max-width:400px;">
			<input type="text"
				   name="search"
				   class="form-control"
				   placeholder="Search by event name..."
				   value="<?= htmlspecialchars($search) ?>">

			<button type="submit" class="btn btn-secondary">Search</button>
			<a href="events.php" class="btn btn-outline-secondary">Clear</a>
		</div>
	</form>

	<div class="card-body">

		<?php if (!empty($events)): ?>

		<div class="table-responsive">
			<table class="table align-middle">

				<thead>
					<tr>
					<th>Name</th>
					<th>Location</th>
					<th>Date</th>
					<th>Image</th>
					<th>Leads</th>				
					<th>QR/Code</th>				
					<th>Actions</th>
					</tr>
				</thead>

				<tbody>

					<?php foreach ($events as $event): 
						$qrFile = "../qrcodes/event_".$event['id'].".png";						
					?>
					<tr>

						<td><?= htmlspecialchars($event['name']) ?></td>
						<td><?= htmlspecialchars($event['location']) ?></td>
						<td><?= htmlspecialchars($event['event_date']) ?></td>

						<td>
							<?php if($event['image']==""){ ?>
								<img src="../uploads/events-default.jpg" class="event-thumb">
							<?php } else{ ?>
								<img src="../uploads/<?= htmlspecialchars($event['image']) ?>" class="event-thumb">
							<?php } ?>
							
						</td>

						<td>
							<div class="">

								<a href="leads.php?event_id=<?= $event['id'] ?>"
								   class="btn btn-sm btn-outline-primary">
									View Leads
								</a>

							</div>
						
						</td>
						
						<td>
							<?php if (file_exists($qrFile)): ?>
								<div class="text-center qr-preview">
									<img src="<?= $qrFile ?>" width="100" class="mb-3">									
								</div>
								<div class="text-center qr-preview">
									<a href="<?= $qrFile ?>" download class="btn btn-outline-secondary">Download QR</a>
								</div>
							<?php endif; ?>
						</td>

						<td>
							<a href="edit_event.php?id=<?= $event['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
							<a href="delete_event.php?id=<?= $event['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure want to delete event?')">Delete</a>
						</td>

					</tr>
					<?php endforeach; ?>

				</tbody>
			</table>
		</div>

		<nav>
			<ul class="pagination">

				<?php if ($page > 1): ?>
				<li class="page-item">
					<a class="page-link" href="?page=<?= $page-1 ?>">Previous</a>
				</li>
				<?php endif; ?>

				<?php for ($i=1; $i <= $totalPages; $i++): ?>
				<li class="page-item <?= $i==$page?'active':'' ?>">
					<a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
				</li>
				<?php endfor; ?>

				<?php if ($page < $totalPages): ?>
				<li class="page-item">
					<a class="page-link" href="?page=<?= $page+1 ?>">Next</a>
				</li>
				<?php endif; ?>

			</ul>
		</nav>

		<?php else: ?>

		<div class="empty-state">
			<h5>No events yet</h5>
			<p>Create your first event to start collecting leads.</p>
			<a href="add_event.php" class="btn btn-primary mt-2">Create Event</a>
		</div>

		<?php endif; ?>

	</div>
</div>

<?php include '../includes/footer.php'; ?>