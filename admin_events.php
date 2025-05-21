<?php
include 'header.php';
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if (isset($_POST['add'])) {
    $stmt = $pdo->prepare("INSERT INTO events (title, description, event_date) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['title'], $_POST['description'], $_POST['event_date']]);
}
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
}

$events = $pdo->query("SELECT * FROM events ORDER BY event_date DESC")->fetchAll();
?>

<h2>Manage Events</h2>
<form method="POST">
    <input type="text" name="title" placeholder="Title" required>
    <textarea name="description" placeholder="Description" required></textarea>
    <input type="date" name="event_date" required>
    <button name="add">Add Event</button>
</form>

<h3>Existing Events</h3>
<table border="1">
<tr><th>Title</th><th>Date</th><th>Action</th></tr>
<?php foreach ($events as $e): ?>
<tr>
    <td><?= htmlspecialchars($e['title']) ?></td>
    <td><?= $e['event_date'] ?></td>
    <td><a href="?delete=<?= $e['id'] ?>" onclick="return confirm('Delete this event?')">Delete</a></td>
</tr>
<?php endforeach; ?>
</table>

<?php include 'footer.php'; ?>
