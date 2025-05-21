<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Ensure session is started only once
}


$timeout_duration = 600; // 10 minutes in seconds

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Check for session timeout
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: login.php?timeout=1");
    exit();
}

// Refresh session activity timestamp
$_SESSION['LAST_ACTIVITY'] = time();

function requireRole($requiredRole) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $requiredRole) {
       
        header("Location: index.php"); // Redirect to a user dashboard or error page
        exit("Access Denied: Insufficient permissions."); // Fallback message
    }
}

?>
