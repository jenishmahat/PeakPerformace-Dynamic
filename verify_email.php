<?php
include 'db.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE verify_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        $update = $pdo->prepare("UPDATE users SET email_verified = 1, verify_token = NULL WHERE id = ?");
        $update->execute([$user['id']]);

        echo "<div style='text-align:center; padding:60px; font-family:sans-serif;'>
                <h2 style='color:green'>✅ Email Verified!</h2>
                <p>You can now <a href='login.php'>log in</a>.</p>
              </div>";
    } else {
        echo "<div style='text-align:center; padding:60px; font-family:sans-serif;'>
                <h2 style='color:red'>❌ Invalid or expired token</h2>
                <p>Please register again or contact support.</p>
              </div>";
    }
} else {
    echo "<div style='text-align:center; padding:60px; font-family:sans-serif;'>
            <h2 style='color:red'>❌ No token provided</h2>
            <p>Please check your email link.</p>
          </div>";
}
?>
