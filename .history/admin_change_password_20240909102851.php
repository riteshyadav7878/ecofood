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

        // Prepare and execute the query to fetch the current admin details
        $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_id = ?");
        $stmt->bind_param('i', $admin_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();

            // Verify the current password
            if (password_verify($current_password, $admin['password'])) {
                echo "Current password verified successfully.<br>"; // Debugging message

                // Check if the new password and confirmation match
                if ($new_password === $confirm_password) {
                    echo "New password matches confirmation.<br>"; // Debugging message

                    // Hash the new password
                    $hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);
                    echo "New hashed password: $hashed_new_password<br>"; // Debugging message

                    // Prepare and execute the update query
                    $update_stmt = $conn->prepare("UPDATE admin SET password = ? WHERE admin_id = ?");
                    $update_stmt->bind_param('si', $hashed_new_password, $admin_id);

                    if ($update_stmt->execute()) {
                        echo '<div class="alert alert-success" role="alert">Password changed successfully.</div>';
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Error updating password: ' . $conn->error . '</div>';
                    }
                    $update_stmt->close();
                } else {
                    echo '<div class="alert alert-warning" role="alert">New password and confirmation do not match.</div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Current password is incorrect.</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Admin not found.</div>';
        }
        $stmt->close();
    }
}

// Close connection
$conn->close();
?>
