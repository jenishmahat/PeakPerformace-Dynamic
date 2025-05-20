<?php
include 'db.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE verify_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        $pdo->prepare("UPDATE users SET is_verified = 1, verify_token = NULL WHERE id = ?")->execute([$user['id']]);
        echo "✅ Email verified! You can now <a href='login.php'>login</a>.";
    } else {
        echo "❌ Invalid or expired token.";
    }
} else {
    echo "❌ No token provided.";
}
?>
