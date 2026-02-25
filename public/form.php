<?php
require '../config/database.php';

$event_id = filter_input(INPUT_GET, 'event_id', FILTER_VALIDATE_INT);

if (!$event_id) die("Invalid event");

$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch();

if (!$event) die("Event not found");

$success = isset($_GET['success']);
?>

	<!DOCTYPE html>
	<html>
	<head>

		<title><?= htmlspecialchars($event['name']) ?></title>

		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="assets/css/event-form.css" rel="stylesheet">

	</head>

	<body>

		<!-- HERO -->
		<div class="hero">

			<?php if ($event['image']): ?>
				<img src="../uploads/<?= htmlspecialchars($event['image']) ?>">
			<?php endif; ?>

			<div class="hero-overlay"></div>

			<div class="hero-content">

				<div class="event-title"><?= htmlspecialchars($event['name']) ?></div>

				<div class="mt-2">
					<span class="badge-soft">📅 <?php echo date('d M Y', strtotime($event['event_date'])); ?></span>
					<span class="badge-soft">📍 <?= htmlspecialchars($event['location']) ?></span>
				</div>

			</div>

		</div>

		<div class="container">

			<div class="row justify-content-center">

				<div class="col-lg-8">

					<!-- DESCRIPTION -->
					<div class="card shadow-sm mt-4">
						<div class="card-body">

							<p class="text-muted mb-0">
							<?= nl2br(htmlspecialchars($event['description'])) ?>
							</p>

						</div>
					</div>

					<!-- FORM -->
					<div class="card shadow-lg form-card mt-4">
					<div class="card-body p-4">

						<form action="submit.php" method="post">

							<input type="hidden" name="event_id" value="<?= $event_id ?>">

							<div class="row g-3">

								<div class="col-md-6">
									<input name="first_name" class="form-control" placeholder="First name" required>
								</div>

								<div class="col-md-6">
									<input name="surname" class="form-control" placeholder="Surname" required>
								</div>

								<div class="col-md-6">
									<input name="company" class="form-control" placeholder="Company">
								</div>

								<div class="col-md-6">
									<input name="phone" class="form-control" placeholder="Phone">
								</div>

								<div class="col-12">
									<input type="email" name="email" class="form-control" placeholder="Email address" required>
								</div>

								<div class="col-12">
									<textarea name="notes" class="form-control" placeholder="Notes"></textarea>
								</div>

							</div>

							<button class="btn btn-primary w-100 mt-4">
							Register Now
							</button>

						</form>

					</div>
					</div>

				</div>
			</div>

		</div>

	</body>
</html>