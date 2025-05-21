<?php
$page_title = "Reset Password - Peak Performance";
include 'header.php';
include 'db.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $pdo->prepare("SELECT email FROM password_resets WHERE token = ? AND expires_at > NOW()");
    $stmt->execute([$token]);
    $row = $stmt->fetch();

    if (!$row) {
        die("<div class='alert alert-danger text-center m-5'>Invalid or expired token.</div>");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = $row['email'];

        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->execute([$new_password, $email]);

        $pdo->prepare("DELETE FROM password_resets WHERE email = ?")->execute([$email]);

        echo "<div class='alert alert-success text-center m-5'>Password updated! <a href='login.php'>Login here</a></div>";
        exit();
    }
} else {
    die("<div class='alert alert-danger text-center m-5'>No token provided.</div>");
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
  html, body {
    height: 100%;
    font-family: 'Poppins', sans-serif;
    display: flex;
    flex-direction: column;
    margin: 0;
  }
  main.main-content {
    flex: 1;
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>

<main class="main-content d-flex align-items-center justify-content-center vh-100">
  <div class="card shadow-lg p-4" style="width: 100%; max-width: 450px;">
    <h3 class="text-center text-success mb-4">Reset Your Password</h3>
    <form method="POST" role="form" aria-label="Reset password form">
      <div class="mb-3">
        <label for="password" class="form-label visually-hidden">New Password</label>
        <input type="password" id="password" name="password" class="form-control" aria-label="New password" placeholder="Enter new password" required>
      </div>
      <button type="submit" class="btn btn-success w-100" aria-label="Submit new password">Reset Password</button>
    </form>
  </div>
</main>

<?php include 'footer.php'; ?>
