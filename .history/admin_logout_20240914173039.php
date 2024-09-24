<?php
session_start(); // Start the session

// Check if admin is logged in, if so, log them out
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session.
    session_destroy();

    // Redirect to login page
    header("Location: admin_login.php");
    exit();
} else {
    // If admin is not logged in, redirect to login page directly
    header("Location: admin_login.php");
    exit();
}
