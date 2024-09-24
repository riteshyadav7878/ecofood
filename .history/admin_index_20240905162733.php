<?php
session_start(); // Start the session

// Include database connection
include('conn.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php"); // Redirect to login page if not logged in
    exit();
}

include 'admin_Navbar.php'; // Include the admin navbar
?>

<h1>Welcome to the Admin Site</h1>

<?php include 'admin_Footer.php'; ?>
