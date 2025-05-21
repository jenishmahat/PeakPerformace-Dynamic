<?php
$page_title = "Login - Peak Performance";
include 'header.php';
include 'db.php';
session_start();

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_login_attempt'] = time();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
  body {
    font-family: 'Poppins', sans-serif;
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>

<main class="main-content d-flex align-items-center justify-content-center vh-100">
  <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
    <h3 class="text-center text-success mb-4">Login</h3>
    <form role="form" aria-label="Main form" method="POST">
      <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" aria-label="Email address" required placeholder="Enter your email">
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" aria-label="Password" required placeholder="Enter your password">
      </div>

      <button type="submit" name="login" class="btn btn-success w-100">Login</button>
    </form>

    <div class="text-center mt-3">
      <a href="signup.php" class="d-block">Don't have an account? Sign up here</a>
      <a href="forgot_password.php" class="d-block">Forgot Password?</a>
    </div>

    <?php
    if (isset($_POST['login'])) {
        if ($_SESSION['login_attempts'] >= 5 && (time() - $_SESSION['last_login_attempt']) < 300) {
            echo "<div class='alert alert-danger mt-3'>Too many failed attempts. Try again later.</div>";
        } else {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $csrf_token = $_POST['csrf_token'] ?? '';

            if (!hash_equals($_SESSION['csrf_token'], $csrf_token)) {
                echo "<div class='alert alert-danger mt-3'>Invalid CSRF token.</div>";
            } else {
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
                $stmt->execute(['email' => $email]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password'])) {
                    session_regenerate_id(true);
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['login_attempts'] = 0;
                    header("Location: " . ($user['role'] === 'admin' ? "admin.php" : "dashboard.php"));
                    exit;
                } else {
                    $_SESSION['login_attempts'] += 1;
                    $_SESSION['last_login_attempt'] = time();
                    echo "<div class='alert alert-danger mt-3'>" . htmlspecialchars("Invalid email or password") . "</div>";
                }
            }
        }
    }
    ?>
  </div>
</main>

<?php include 'footer.php'; ?>