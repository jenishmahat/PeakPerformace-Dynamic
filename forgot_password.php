<?php
$page_title = "Forgot Password - Peak Performance";
include 'header.php';
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(50));
    $expiry = date("Y-m-d H:i:s", strtotime("+30 minutes"));

    $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
    $stmt->execute([$email, $token, $expiry]);

    $reset_link = "http://localhost/PeakPerformance_Dynamic/reset_password.php?token=$token";
    $message = "Reset link sent. <a href='$reset_link'>Click here to reset password</a>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $page_title ?></title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="auth.css"> <!-- 🔗 Your custom form styles -->
</head>
<body>


  <main class="main-content">
    <div class="form-container">
      <h2>Forgot Password</h2>

      <?php if (!empty($message)): ?>
        <div class="success-msg"><?= $message ?></div>
      <?php endif; ?>

      <form method="POST">
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit">Send Reset Link</button>
      </form>
      <p><a href="login.php">Back to login</a></p>
    </div>
  </main>

  <?php include 'footer.php'; ?>
</body>
</html>
