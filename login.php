<?php
$page_title = "Login - Peak Performance";
include 'header.php';
include 'db.php';
session_start();
?>

<main class="main-content">
  <div class="form-container">
    <h2>Login</h2>
    <form method="POST">
      <input type="email" name="email" required placeholder="Email">
      <input type="password" name="password" required placeholder="Password">
      <button type="submit" name="login">Login</button>
    </form>
    <a href="signup.php">Don't have an account? Sign up here</a>
    <a href="forgot_password.php">Forgot Password?</a>


    <?php
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            header("Location: " . ($user['role'] === 'admin' ? "admin.php" : "dashboard.php"));
            exit;
        } else {
            echo "<p style='color:red'>Invalid email or password</p>";
        }
    }
    ?>
  </div>
</main>


<?php include 'footer.php'; ?>