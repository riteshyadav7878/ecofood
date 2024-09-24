<?php
session_start(); // Start the session

// Include database connection
include('conn.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php"); // Redirect to login page if not logged in
    exit();
}
?>

<?php include 'admin_Navbar.php'; ?>

 <h1 class="mt-5 text-center mb-5">Welcome to dmin site pages</h1>

<?php include 'admin_Footer.php'; ?>