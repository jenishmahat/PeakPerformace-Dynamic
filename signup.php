<?php
$page_title = "Sign Up - Peak Performance";
include 'header.php';
include 'db.php';
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
        echo "<p style='color:red; text-align:center;'>Passwords do not match.</p>";
    } else {
        $hashed = hash('sha256', $password);

        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $first, $last, $email, $hashed);

        if ($stmt->execute()) {
            echo "<p style='color:green; text-align:center;'>Account created! <a href='login.php'>Log in</a></p>";
        } else {
            echo "<p style='color:red; text-align:center;'>Error: " . $stmt->error . "</p>";
        }
    }
}
include 'footer.php';
?>
