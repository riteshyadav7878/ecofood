<?php
session_start(); // Start the session

// Include database connection
include('conn.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php"); // Redirect to login page if not logged in
    exit();
}

// Handling form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_user'])) {
        $user_id = intval($_POST['user_id']);

        // SQL query to delete user
        $sql = "DELETE FROM user WHERE id = $user_id";
        if ($conn->query($sql) === TRUE) {
            // Check if the deleted user is the currently logged-in user
            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user_id) {
                // Destroy the session and log the user out
                session_destroy();
                // Redirect to the login page
                header("Location: user_login.php");
                exit();
            }
            $_SESSION['message'] = 'User deleted successfully';
        } else {
            $_SESSION['message'] = 'Error: ' . $conn->error;
        }
        header("Location: admin_users.php"); // Redirect to avoid form resubmission
        exit();
    }
}

// Fetch users without status information
$sql = "SELECT * FROM user ORDER BY id DESC";
$result = $conn->query($sql);
// Close connection
$conn->close();
?>
