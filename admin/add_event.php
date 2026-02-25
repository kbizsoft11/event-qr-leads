<?php 
require '../config/database.php';
require '../config/app.php';
require '../includes/functions.php';
require '../includes/auth.php';

include '../phpqrcode/qrlib.php';

$success = false;

if ($_POST) {

    $imageName = null;

    if (!empty($_FILES['image']['name'])) {
        $imageName = time().'_'.$_FILES['image']['name'];

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            '../uploads/'.$imageName
        );
    }

    $stmt = $pdo->prepare("
    INSERT INTO events (name, description, location, event_date, image)
    VALUES (:name, :description, :location, :event_date, :image)
    ");

    $stmt->execute([
        ':name' => $_POST['name'],
        ':description' => $_POST['description'],
        ':location' => $_POST['location'],
        ':event_date' => $_POST['event_date'],
        ':image' => $imageName
    ]);

    // ⭐ Get new event ID
    $eventId = $pdo->lastInsertId();

    // ⭐ Build form URL
   
	$formUrl2 = APP_URL."/public/form.php?event_id=".$eventId;

    // ⭐ Ensure QR folder exists
    if (!file_exists('../qrcodes')) {
        mkdir('../qrcodes', 0777, true);
    }

    // ⭐ Generate QR
    $qrFile = "../qrcodes/event_".$eventId.".png";

    QRcode::png($formUrl2, $qrFile, QR_ECLEVEL_L, 6);

    $success = true;
	header("Location: events.php?created=1");
    exit;
}

include '../includes/header.php';
?>

<div class="page-header">
	<div class="page-title">Create Event</div>
	<div class="page-subtitle">Add event details to start collecting leads</div>
</div>

<?php if ($success): ?>
	<div class="alert alert-success">Event created successfully.</div>
<?php endif; ?>

<div class="card shadow-sm form-card">
	<div class="card-body">

		<form method="post" enctype="multipart/form-data">

			<div class="section-title">Event Information</div>

			<div class="mb-3">
				<label>Event Name</label>
				<input name="name" class="form-control" placeholder="Enter event name" required>
			</div>

			<div class="mb-3">
				<label>Description</label>
				<textarea name="description" class="form-control" rows="4"></textarea>
			</div>

			<div class="row">

				<div class="col-md-6 mb-3">
				<label>Location</label>
				<input name="location" class="form-control">
				</div>

				<div class="col-md-6 mb-3">
				<label>Date</label>
				<input type="date" name="event_date" class="form-control">
				</div>

			</div>

			<div class="section-title mt-4">Event Banner</div>

			<div class="upload-box">

				<img id="preview" class="image-preview d-none">

				<input type="file" name="image" id="imageInput" class="form-control">

				<small class="text-muted">Upload banner image</small>

			</div>

			<button class="btn btn-primary mt-4">Create Event</button>

		</form>

	</div>
</div>

<script>
document.getElementById('imageInput').addEventListener('change', function(e){
    const file = e.target.files[0];
    if(!file) return;

    const reader = new FileReader();
    reader.onload = function(e){
        const img = document.getElementById('preview');
        img.src = e.target.result;
        img.classList.remove('d-none');
    };
    reader.readAsDataURL(file);
});
</script>

<?php include '../includes/footer.php'; ?>