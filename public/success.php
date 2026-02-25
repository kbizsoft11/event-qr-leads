<?php
require '../config/database.php';

$event_id = (int)$_GET['event_id'];

$stmt = $pdo->prepare("SELECT name FROM events WHERE id=?");
$stmt->execute([$event_id]);

$event = $stmt->fetch();
?>

<!DOCTYPE html>
<html>
<head>

<title>Registration Complete</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
	body {
		background: linear-gradient(135deg,#4facfe,#00f2fe);
		min-height:100vh;
		display:flex;
		align-items:center;
	}

	.card {
		border-radius:16px;
	}
</style>

</head>

<body>

	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">

			<div class="card shadow-lg">
			<div class="card-body text-center p-5">

			<h1 style="font-size:60px;">✅</h1>

			<h3 class="mb-3">You're Registered!</h3>

			<p class="text-muted">
			Thank you for registering for
			<strong><?= htmlspecialchars($event['name']) ?></strong>.
			</p>

			<p class="text-muted">
			Our team will be in touch — we look forward to seeing you at the event.
			</p>

			<a href="form.php?event_id=<?= $event_id ?>" class="btn btn-primary mt-3">
			Go Back
			</a>

			</div>
			</div>

			</div>
		</div>
	</div>

</body>
</html>