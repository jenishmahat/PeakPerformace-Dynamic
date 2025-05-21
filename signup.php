<?php
$page_title = "Sign Up - Peak Performance";
include 'header.php';
include 'db.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
  body { font-family: 'Poppins', sans-serif; }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>

<main class="main-content d-flex align-items-center justify-content-center vh-100">
  <div class="card shadow-lg p-4" style="width: 100%; max-width: 500px;">
    <h3 class="text-center text-success mb-4">Sign Up</h3>
    <form role="form" aria-label="User registration form" method="POST">
      <div class="mb-3 d-flex gap-2">
        <input type="text" class="form-control" name="first_name" aria-label="First Name" required placeholder="First Name">
        <input type="text" class="form-control" name="last_name" aria-label="Last Name" required placeholder="Last Name">
      </div>
      <div class="mb-3">
        <input type="email" class="form-control" name="email" aria-label="Email address" required placeholder="Email">
      </div>
      <div class="mb-3">
        <input type="password" class="form-control" name="password" aria-label="Password" required placeholder="Password">
      </div>
      <div class="mb-3">
        <input type="password" class="form-control" name="confirm_password" aria-label="Confirm Password" required placeholder="Confirm Password">
      </div>
      <button type="submit" name="register" class="btn btn-success w-100" aria-label="Submit registration">Sign Up</button>
    </form>

    <div class="text-center mt-3">
      <a href="login.php">Already have an account? Log in</a>
    </div>

    <?php
    if (isset($_POST['register'])) {
        $first = $_POST['first_name'];
        $last = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm = $_POST['confirm_password'];

        if ($password !== $confirm) {
            echo "<div class='alert alert-danger mt-3' role='alert'>Passwords do not match</div>";
            return;
        }

        $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);
        if ($check->rowCount() > 0) {
            echo "<div class='alert alert-warning mt-3' role='alert'>Email already registered. Please log in or use another email.</div>";
            return;
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(32));

        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password, role, verify_token, email_verified)
                               VALUES (:first, :last, :email, :password, 'member', :token, 0)");

        try {
            $stmt->execute([
                'first' => $first,
                'last' => $last,
                'email' => $email,
                'password' => $hashed,
                'token' => $token
            ]);

            $verify_link = "http://localhost/PeakPerformance_Dynamic/verify_email.php?token=$token";

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'email-smtp.ap-southeast-2.amazonaws.com'; // SES endpoint for Sydney
            $mail->SMTPAuth   = true;
            $mail->Username   = 'AKIASLA2O2FCVIN7JU4Q'; // Your SMTP username (IAM)
            $mail->Password   = 'BEE8FgFbQpt+2PZO7hwHQ9JyoekZa5XXrdOEe43Eowm8'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('jenishmahat101@gmail.com', 'Peak Performance');   
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Verify your email address';
            $mail->Body    = "Hi <b>$first</b>,<br><br>Please click the link below to verify your email:<br><a href='$verify_link'>$verify_link</a><br><br>Thanks!";

            $mail->send();
            echo "<div class='alert alert-success mt-3' role='alert'>Registration successful! Please check your email to verify your account.</div>";
        } catch (Exception $e) {
            echo "<div class='alert alert-danger mt-3' role='alert'>Email could not be sent. Error: {$mail->ErrorInfo}</div>";
        }
    }
    ?>
  </div>
</main>

<?php include 'footer.php'; ?>
