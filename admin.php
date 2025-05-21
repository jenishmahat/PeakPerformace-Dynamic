<?php
$page_title = "Admin Panel - Peak Performance";
include 'auth.php';
requireRole('admin');
include 'header.php';
include 'db.php';

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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $page_title ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    html, body {
      height: 100%;
      font-family: 'Poppins', sans-serif;
    }
    .wrapper {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    main {
      flex: 1;
    }
  </style>
</head>
<body>

<div class="wrapper">
  <main class="main-content py-5">
    <div class="container">
      <div class="card shadow p-4">
        <h2 class="text-center text-success mb-4">Admin Panel</h2>
        <p class="text-center">Welcome, <?= htmlspecialchars($_SESSION['email']); ?>!</p>

        <h4><?= $id ? "Edit User" : "Add New User"; ?></h4>
        <form method="POST" class="row g-3 mb-4">
          <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
          <div class="col-md-5">
            <input type="email" name="email" class="form-control" placeholder="Email" required value="<?= htmlspecialchars($email) ?>">
          </div>
          <div class="col-md-3">
            <select name="role" class="form-select" required>
              <option value="user" <?= $role === 'user' ? 'selected' : '' ?>>User</option>
              <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
          </div>
          <div class="col-md-2">
            <button type="submit" name="save" class="btn btn-success w-100">Save</button>
          </div>
        </form>

        <h4>User List</h4>
        <table class="table table-bordered table-hover">
          <thead class="table-success">
            <tr>
              <th>ID</th>
              <th>Email</th>
              <th>Role</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
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
                        <a href='admin.php?edit=$id' class='btn btn-sm btn-primary me-2'>Edit</a>
                        <a href='admin.php?delete=$id' class='btn btn-sm btn-danger' onclick=\"return confirm('Delete this user?')\">Delete</a>
                      </td>
                    </tr>";
          }
          ?>
          </tbody>
        </table>

        <div class="row g-2 mb-6">
          <div class="col-md-6">
            <button type="button" class="btn btn-success w-100" onclick="window.location.href='admin_activities.php'">Add Activities</button>
          </div>
          <div class="col-md-6">
            <button type="button" class="btn btn-success w-100" onclick="window.location.href='events.php'">Add Events</button>
          </div>
        </div>

        <div class="text-center">
          <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
        </div>
      </div>
    </div>
  </main>

  <?php include 'footer.php'; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
</body>
</html>
