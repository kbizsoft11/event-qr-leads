<?php
require '../includes/auth.php';
require '../config/database.php';
require '../config/app.php';

require '../includes/functions.php';
include '../phpqrcode/qrlib.php';

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$id]);

$event = $stmt->fetch();

$imageName = $event['image'];

if (!empty($_FILES['image']['name'])) {

    $allowed = ['image/jpeg','image/png','image/webp'];

    if (!in_array($_FILES['image']['type'], $allowed)) {
        die("Invalid image type");
    }

    $imageName = time().'_'.basename($_FILES['image']['name']);

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        '../uploads/'.$imageName
    );
}

if (isset($_POST['update_event_data'])) {

    $stmt = $pdo->prepare("
	UPDATE events
	SET name=?, description=?, location=?, event_date=?, image=?
	WHERE id=?
	");

    $stmt->execute([
		$_POST['name'],
		$_POST['description'],
		$_POST['location'],
		$_POST['event_date'],
		$imageName,
		$id
	]);

    header("Location: events.php?created=1");
    exit;
}
?>

<?php
$qrFile = "../qrcodes/event_".$id.".png";

$formUrl = APP_URL."/public/form.php?event_id=".$id;

if (isset($_POST['generate_qr'])) {

    if (!file_exists('../qrcodes')) {
        mkdir('../qrcodes', 0777, true);
    }

    QRcode::png($formUrl, $qrFile, QR_ECLEVEL_L, 6);

    echo "<div class='alert alert-success'>QR generated</div>";
}

include '../includes/header.php';
?>

<div class="editor-header">
    <div class="editor-title">Edit Event</div>
    <a href="events.php" class="btn btn-outline-secondary">← Back to Events</a>
</div>

<div class="row">

	<!-- LEFT COLUMN -->
	<div class="col-lg-7">

		<div class="card shadow-sm section-card mb-4">
			<div class="card-body">

				<div class="section-title">Event Details</div>

				<form method="post" enctype="multipart/form-data">

					<div class="mb-3">
						<label>Event Name</label>
						<input name="name" value="<?= htmlspecialchars($event['name']) ?>" class="form-control">
					</div>

					<div class="mb-3">
						<label>Description</label>
						<textarea name="description" class="form-control"><?= htmlspecialchars($event['description']) ?></textarea>
					</div>

					<div class="row">
						<div class="col-md-6 mb-3">
							<label>Location</label>
							<input name="location" value="<?= htmlspecialchars($event['location']) ?>" class="form-control">
						</div>

						<div class="col-md-6 mb-3">
							<label>Date</label>
							<input type="date" name="event_date" value="<?= $event['event_date'] ?>" class="form-control">
						</div>
					</div>

					<div class="section-title">Event Banner</div>

					<div class="image-uploader text-center">

						<?php if (!empty($event['image'])): ?>
						<img id="imagePreview"
							 src="../uploads/<?= htmlspecialchars($event['image']) ?>"
							 class="img-fluid mb-3 rounded"
							 style="max-height:220px;">
						<?php else: ?>
						<img id="imagePreview"
							 class="img-fluid mb-3 d-none rounded"
							 style="max-height:220px;">
						<?php endif; ?>

						<input type="file" name="image" id="imageInput" class="form-control">

					</div>

					<button name="update_event_data" class="btn btn-success mt-3">Save Changes</button>

				</form>

			</div>
		</div>

	</div>

	<!-- RIGHT COLUMN -->
	<div class="col-lg-5">

		<div class="card shadow-sm section-card">
			<div class="card-body">

				<div class="section-title">QR Code</div>

				<form method="post">
					<button name="generate_qr" class="btn btn-primary mb-3 w-100">
						Generate / Refresh QR
					</button>
				</form>

				<?php if (file_exists($qrFile)): ?>
				<div class="text-center qr-preview">

					<img src="<?= $qrFile ?>" width="220" class="mb-3">

					<a href="<?= $qrFile ?>" download class="btn btn-outline-secondary w-100">
					Download QR
					</a>

				</div>
				<?php else: ?>
					<p class="text-muted">No QR generated yet.</p>
				<?php endif; ?>

			</div>
		</div>

	</div>

</div>