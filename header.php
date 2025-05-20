<?php
// Only start session if not already active
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }

// Get current page name
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo isset($page_title) ? $page_title : 'Peak Performance Sports Club'; ?></title>

  <link rel="icon" href="images/ic.png" type="image/png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link rel="stylesheet" href="style.css">
  <?php if (basename($_SERVER['PHP_SELF']) === 'login.php' || basename($_SERVER['PHP_SELF']) === 'signup.php' || basename($_SERVER['PHP_SELF']) === 'dashboard.php'|| basename($_SERVER['PHP_SELF'])==='admin.php'): ?>
    <link rel="stylesheet" href="auth.css">
  <?php endif; ?>
  <script defer src="script.js"></script>
</head>
<body>

<header>
  <div class="logo">
    <img src="images/logo.png" alt="Peak Performance Logo" />
    <span>Peak Performance Sport Club</span>
  </div>
  <div class="menu-toggle" id="menu-toggle">
    <i class="fas fa-bars"></i>
  </div>

  <nav id="navbar">
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="activities.php">Activities</a></li>
      <li><a href="membership.php">Membership</a></li>
      <li><a href="events.php">Events</a></li>
      <li><a href="about.php">About</a></li>
      <li><a href="contact.php">Contact</a></li>
      <?php if (isset($_SESSION['email'])): ?>
        <li><a href="dashboard.php">Dashboard</a></li>
        <?php if ($_SESSION['role'] === 'admin'): ?>
          <li><a href="admin.php">Admin Panel</a></li>
        <?php endif; ?>
        <li><a href="logout.php">Logout</a></li>
      <?php else: ?>
        <li><a href="login.php">Login</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>
