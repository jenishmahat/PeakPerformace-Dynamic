<?php
$page_title = "Dashboard - Peak Performance";
include 'auth.php';
include 'header.php';
include 'db.php';

$email = $_SESSION['email'];
$query = $pdo->prepare("SELECT first_name, last_name FROM users WHERE email = :email");
$query->bindParam(':email', $email);
$query->execute();
$user = $query->fetch(PDO::FETCH_ASSOC);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
  html, body {
    height: 100%;
    margin: 0;
    font-family: 'Poppins', sans-serif;
    display: flex;
    flex-direction: column;
  }
  main.main-content {
    flex: 1;
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>

<main class="main-content py-5">
  <div class="container">
    <div class="card shadow p-4">
      <h2 class="text-center text-success mb-4">
        Welcome, <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?> 
      </h2>
      <div class="row mb-4">
        <div class="col-md-4">
          <div class="border p-3 rounded bg-light">
            <strong>Email:</strong><br>
            <?= htmlspecialchars($email); ?>
          </div>
        </div>
        <div class="col-md-4">
          <div class="border p-3 rounded bg-light">
            <strong>Membership:</strong><br>
            Basic Member
          </div>
        </div>
        <div class="col-md-4">
          <div class="border p-3 rounded bg-light">
            <strong>Status:</strong><br>
            Active
          </div>
        </div>
      </div>

      <div class="d-flex flex-column gap-3 align-items-center">
        <a href="membership.php" class="btn btn-outline-success w-50">Upgrade Membership</a>
        <a href="events.php" class="btn btn-outline-success w-50">Join an Event</a>
        <a href="contact.php" class="btn btn-outline-success w-50">Contact a Coach</a>
        <a href="logout.php" class="btn btn-danger w-50 mt-3">Logout</a>
      </div>
    </div>
  </div>
</main>

<?php include 'footer.php'; ?>
