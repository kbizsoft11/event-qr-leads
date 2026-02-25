<!DOCTYPE html>
<html>
<head>

<title>Admin Dashboard</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../admin/assets/css/events.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

<div class="container">

<a class="navbar-brand" href="index.php">QR Leads Admin</a>

<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navMenu">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navMenu">

<ul class="navbar-nav me-auto">

<li class="nav-item">
<a class="nav-link <?= $currentPage=='index.php'?'active':'' ?>"
   href="index.php">Dashboard</a>
</li>

<li class="nav-item">
<a class="nav-link <?= $currentPage=='events.php'?'active':'' ?>"
   href="events.php">Events</a>
</li>

<li class="nav-item">
<a class="nav-link <?= $currentPage=='leads.php'?'active':'' ?>"
   href="leads.php">Leads</a>
</li>

</ul>

<div class="d-flex">
<a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
</div>

</div>

</div>

</nav>

<div class="container py-4">