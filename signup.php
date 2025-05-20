<?php
$page_title = "Sign Up - Peak Performance";
include 'header.php';
include 'db.php';
session_start();
?>

<div class="form-container">
  <h2>Sign Up</h2>
  <form method="POST">
      <div class="form-row">
        <input type="text" name="first_name" required placeholder="First Name">
        <input type="text" name="last_name" required placeholder="Last Name">
      </div>
    <input type="email" name="email" required placeholder="Email">
    <input type="password" name="password" required placeholder="Password">
    <input type="password" name="confirm_password" required placeholder="Confirm Password">
    <button type="submit" name="register">Sign Up</button>
  </form>
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
        echo "<p style='color:red'>Passwords do not match</p>";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password, role) VALUES (:first, :last, :email, :password, 'member')");
        try {
            $stmt->execute([
                'first' => $first,
                'last' => $last,
                'email' => $email,
                'password' => $hashed
            ]);
            echo "<p style='color:green'>Registration successful! You can now <a href='login.php'>log in</a>.</p>";
        } catch (PDOException $e) {
            echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
        }
    }
}
?>
<?php include 'footer.php'; ?>