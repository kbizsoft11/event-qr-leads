<?php
require '../includes/auth.php';
require '../config/database.php';
include '../includes/header.php';

/* Counts */
$totalEvents = $pdo->query("SELECT COUNT(*) FROM events")->fetchColumn();
$totalLeads = $pdo->query("SELECT COUNT(*) FROM leads")->fetchColumn();
?>

<div class="container">

<h2 class="mb-4">Dashboard</h2>

<div class="row g-4">

<!-- Events Card -->
<div class="col-md-6 col-lg-4">
<div class="card shadow-sm border-0">

<div class="card-body">

<h5 class="card-title text-muted">Total Events</h5>

<h2 class="fw-bold"><?= $totalEvents ?></h2>

<a href="events.php" class="btn btn-outline-primary btn-sm mt-2">
Manage Events
</a>

</div>

</div>
</div>

<!-- Leads Card -->
<div class="col-md-6 col-lg-4">
<div class="card shadow-sm border-0">

<div class="card-body">

<h5 class="card-title text-muted">Total Leads</h5>

<h2 class="fw-bold"><?= $totalLeads ?></h2>

<a href="leads.php" class="btn btn-outline-success btn-sm mt-2">
View Leads
</a>

</div>

</div>
</div>

<!-- Quick Actions -->
<div class="col-md-12 col-lg-4">
<div class="card shadow-sm border-0">

<div class="card-body">

<h5 class="card-title text-muted">Quick Actions</h5>

<div class="d-grid gap-2">

<a href="events.php" class="btn btn-primary">
➕ Create Event
</a>

<a href="leads.php" class="btn btn-success">
📊 View Leads
</a>

</div>

</div>

</div>
</div>

</div>

</div>

<?php include '../includes/footer.php'; ?>