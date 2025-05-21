<?php
$page_title = "Forgot Password - Peak Performance";
include 'header.php';
include 'db.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if email exists
    $check = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $check->execute([$email]);

    if ($check->rowCount() > 0) {
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime("+30 minutes"));

        $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$email, $token, $expiry]);

        $reset_link = "http://localhost/PeakPerformance_Dynamic/reset_password.php?token=$token";

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'email-smtp.ap-southeast-2.amazonaws.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'AKIASLA2O2FCVIN7JU4Q';
            $mail->Password   = 'BEE8FgFbQpt+2PZO7hwHQ9JyoekZa5XXrdOEe43Eowm8'; // 🔐 Replace with actual Brevo key
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('jenishmahat101@gmail.com', 'Peak Performance');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "Hi,<br><br>Click the link below to reset your password:<br><a href='$reset_link'>$reset_link</a><br><br>This link will expire in 30 minutes.";

            $mail->send();
            $message = "<div class='alert alert-success text-center'>Password reset link has been sent to your email.</div>";
        } catch (Exception $e) {
            $message = "<div class='alert alert-danger text-center'>Mailer error: {$mail->ErrorInfo}</div>";
        }
    } else {
        $message = "<div class='alert alert-warning text-center'>Email not found.</div>";
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style> body { font-family: 'Poppins', sans-serif; } </style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>

<main class="main-content d-flex align-items-center justify-content-center vh-100">
  <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
    <h3 class="text-center text-success mb-4">Forgot Password</h3>

    <?= $message ?>

    <form method="POST" role="form" aria-label="Password reset request form">
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" aria-label="Email address" placeholder="Enter your email" required>
      </div>
      <button type="submit" class="btn btn-success w-100" aria-label="Send password reset link">Send Reset Link</button>
    </form>

    <div class="text-center mt-3">
      <a href="login.php">Back to Login</a>
    </div>
  </div>
</main>

<?php include 'footer.php'; ?>
