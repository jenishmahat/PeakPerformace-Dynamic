<?php
$page_title = "Admin Panel - Peak Performance";
include 'auth.php';
if ($_SESSION['role'] !== 'admin') {
    die("Access Denied. <a href='dashboard.php'>Go back</a>");
}
include 'header.php';
include 'db.php';

// Handle Add or Edit
if (isset($_POST['save'])) {
    $email = $_POST['email'];
    $role = $_POST['role'];
    $id = $_POST['id'];

    if ($id) {
        $stmt = $pdo->prepare("UPDATE users SET email = ?, role = ? WHERE id = ?");
        $stmt->execute([$email, $role, $id]);
    } else {
        $defaultPassword = password_hash("123456", PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (email, password, role, first_name, last_name) VALUES (?, ?, ?, '', '')");
        $stmt->execute([$email, $defaultPassword, $role]);
    }

    header("Location: admin.php");
    exit();
}

// Handle Delete
if (isset($_GET['delete'])) {
    if ($_GET['delete'] != $_SESSION['user_id']) {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$_GET['delete']]);
        header("Location: admin.php");
        exit();
    }
}

$email = $role = $id = "";
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $user = $stmt->fetch();
    if ($user) {
        $email = $user['email'];
        $role = $user['role'];
        $id = $user['id'];
    }
}
?>

<main class="main-content">
  <div class="admin-box">

    <h2>Admin Panel</h2>
    <p>Welcome, <?php echo $_SESSION['email']; ?>!</p>

    <h3><?php echo $id ? "Edit User" : "Add New User"; ?></h3>
    <form method="POST">
      <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
      <input type="email" name="email" placeholder="Email" required value="<?= htmlspecialchars($email) ?>">
      <select name="role" required>
        <option value="user" <?= $role === 'user' ? 'selected' : '' ?>>User</option>
        <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Admin</option>
      </select>
      <button type="submit" name="save">Save</button>
    </form>

    <h3>User List</h3>
    <table border="1">
      <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Role</th>
        <th>Actions</th>
      </tr>
      <?php
      $result = $pdo->query("SELECT id, email, role FROM users");
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
          $id = $row['id'];
          $email = htmlspecialchars($row['email']);
          $role = htmlspecialchars($row['role']);
          echo "<tr>
                  <td>$id</td>
                  <td>$email</td>
                  <td>$role</td>
                  <td>
                    <a href='admin.php?edit=$id'>Edit</a> |
                    <a href='admin.php?delete=$id' onclick=\"return confirm('Delete this user?')\">Delete</a>
                  </td>
                </tr>";
      }
      ?>
    </table>

    <p><a class="logout-button" href="logout.php">Logout</a></p>
  </div>
</main>

<?php include 'footer.php'; ?>
