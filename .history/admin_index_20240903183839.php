<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php"); // Redirect to login page
    exit();
}

// Include other necessary files
include 'conn.php';

?>

<?php include 'admin_Navbar.php'; ?>

 <h1>Welcome a admin site pages</h1>

<?php include 'admin_Footer.php'; ?>