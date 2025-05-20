<?php
include 'db.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verify token
    $stmt = $pdo->prepare("SELECT email FROM password_resets WHERE token = ? AND expires_at > NOW()");
    $stmt->execute([$token]);
    $row = $stmt->fetch();

    if (!$row) {
        die("Invalid or expired token.");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = $row['email'];

        // Update user password
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->execute([$new_password, $email]);

        // Remove used token
        $pdo->prepare("DELETE FROM password_resets WHERE email = ?")->execute([$email]);

        echo "Password updated! <a href='login.php'>Login here</a>";
        exit();
    }
} else {
    die("No token provided.");
}
?>

<form method="POST">
  <h2>Reset Your Password</h2>
  <input type="password" name="password" placeholder="New password" required>
  <button type="submit">Reset Password</button>
</form>
