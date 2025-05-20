<?php
$page_title = "Dashboard - Peak Performance";
include 'auth.php';
include 'header.php';
include 'db.php'; // Ensures $pdo is available

// Fetch user details securely using PDO
$email = $_SESSION['email'];
$query = $pdo->prepare("SELECT first_name, last_name FROM users WHERE email = :email");
$query->bindParam(':email', $email);
$query->execute();
$user = $query->fetch(PDO::FETCH_ASSOC);
?>

<div class="dashboard-container">
    <h2>Welcome, <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?> 👋</h2>
    <div class="dashboard-card">
        <p><strong>Email:</strong> <?= htmlspecialchars($email); ?></p>
        <p><strong>Membership:</strong> Basic Member</p>
        <p><strong>Status:</strong> Active</p>
    </div>

    <div class="dashboard-actions">
        <a href="membership.php" class="btn">Upgrade Membership</a>
        <a href="events.php" class="btn">Join an Event</a>
        <a href="contact.php" class="btn">Contact a Coach</a>
    </div>

    <a href="logout.php" class="logout-button">Logout</a>
</div>

<?php include 'footer.php'; ?>


