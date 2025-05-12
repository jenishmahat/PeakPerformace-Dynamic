<?php
$page_title = "Login - Peak Performance";
include 'header.php';
include 'db.php';
?>

<div class="form-container">
  <h2>Login</h2>
  <form method="POST">
    <input type="email" name="email" required placeholder="Email">
    <input type="password" name="password" required placeholder="Password">
    <button type="submit" name="login">Login</button>
  </form>
  <a href="signup.php">Don't have an account? Sign up here</a>
</div>

<?php
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = hash('sha256', $_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $user = $res->fetch_assoc();
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        header("Location: " . ($user['role'] === 'admin' ? "admin.php" : "dashboard.php"));
    } else {
        echo "<p style='color:red; text-align:center;'>Invalid credentials.</p>";
    }
}
include 'footer.php';
?>
