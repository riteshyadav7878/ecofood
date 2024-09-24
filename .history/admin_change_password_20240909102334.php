<?php
session_start(); // Start the session

// Include database connection
include('conn.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php"); // Redirect to login page if not logged in
    exit();
}

include 'admin_Navbar.php'; // Include navbar

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['change_password'])) {
        $current_password = trim($_POST['current_password']);
        $new_password = trim($_POST['new_password']);
        $confirm_password = trim($_POST['confirm_password']);

        // Get the logged-in admin's ID from the session
        $admin_id = $_SESSION['admin_id'];

        // Fetch the current admin details from the database
        $sql = "SELECT * FROM admin WHERE admin_id='$admin_id'"; // Corrected column name
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();

            // Verify the current password
            if (password_verify($current_password, $admin['password'])) {
                // Check if the new password and confirmation match
                if ($new_password === $confirm_password) {
                    // Hash the new password
                    $hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);

                    // Update the password in the database
                    $update_sql = "UPDATE admin SET password='$hashed_new_password' WHERE admin_id='$admin_id'"; // Corrected column name

                    if ($conn->query($update_sql) === TRUE) {
                        echo '<div class="alert alert-success" role="alert">Password changed successfully.</div>';
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Error updating password: ' . $conn->error . '</div>';
                    }
                } else {
                    echo '<div class="alert alert-warning" role="alert">New password and confirmation do not match.</div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Current password is incorrect.</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Admin not found.</div>';
        }
    }
}

// Close connection
$conn->close();
?>
