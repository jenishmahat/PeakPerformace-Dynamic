<?php
$page_title = "Admin Panel - Peak Performance";
include 'auth.php';
if ($_SESSION['role'] !== 'admin') {
    die("Access Denied. <a href='dashboard.php'>Go back</a>");
}
include 'header.php';
include 'db.php';
?>

<h2>Admin Panel</h2>
<p>Welcome, <?php echo $_SESSION['email']; ?>!</p>

<?php
$result = $conn->query("SELECT id, email, role FROM users");
echo "<table border='1'><tr><th>ID</th><th>Email</th><th>Role</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['id']}</td><td>{$row['email']}</td><td>{$row['role']}</td></tr>";
}
echo "</table>";
?>

<a href="logout.php">Logout</a>

<?php include 'footer.php'; ?>
