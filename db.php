<?php
$host = 'localhost';
$user = 'root'; // Default XAMPP username
$pass = '';     // Default XAMPP has no password
$dbname = 'peakperformance';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
