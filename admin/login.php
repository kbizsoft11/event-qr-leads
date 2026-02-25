<?php
session_start();
require '../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$_POST['username']]);

    $admin = $stmt->fetch();

    if ($admin && password_verify($_POST['password'], $admin['password'])) {

        session_regenerate_id(true);

        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $admin['username'];

        header("Location: events.php");
        exit;

    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">
<div class="row justify-content-center">
<div class="col-md-4">

<div class="card shadow">
<div class="card-body">

<div class="text-center mb-3">
    <img src="../images/login_screen.png" alt="Logo" class="img-fluid" style="max-height:90px;">
</div>

<h4 class="mb-4">Admin Login</h4>

<?php if ($error): ?>
<div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post">

<input name="username" class="form-control mb-3" placeholder="Username" required>

<input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

<button class="btn btn-primary w-100">Login</button>

</form>

</div>
</div>

</div>
</div>
</div>

</body>
</html>