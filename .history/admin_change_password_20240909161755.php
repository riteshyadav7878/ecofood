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

// Initialize message variable
$message = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $current_password = trim($_POST['current_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Get the logged-in admin's ID from the session
    $admin_id = $_SESSION['admin_id'];

    // Fetch the current admin details from the database
    $sql = "SELECT * FROM admin WHERE admin_id='$admin_id'";
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
                $update_sql = "UPDATE admin SET password='$hashed_new_password' WHERE admin_id='$admin_id'";

                if ($conn->query($update_sql) === TRUE) {
                    $message = '<div class="alert alert-success" role="alert">Password changed successfully.</div>';
                } else {
                    $message = '<div class="alert alert-danger" role="alert">Error updating password: ' . $conn->error . '</div>';
                }
            } else {
                $message = '<div class="alert alert-warning" role="alert">New password and confirmation do not match.</div>';
            }
        } else {
            $message = '<div class="alert alert-danger" role="alert">Current password is incorrect.</div>';
        }
    } else {
        $message = '<div class="alert alert-danger" role="alert">Admin not found.</div>';
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background for the page */
        }
        .change-password-container {
            max-width: 500px;
            margin-top: 50px;
            padding: 30px;
            border-radius: 10px;
            background-color: #ffffff; /* White background for the form */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }
        .btn-primary {
            background-color: #007bff; /* Bootstrap primary color */
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Darker shade for hover effect */
            border-color: #0056b3;
        }
        h1 {
            color: #343a40; /* Dark gray for heading */
        }
        .form-group label {
            color: #495057; /* Slightly dark gray for labels */
        }
    </style>
</head>
<body>
    <div class="container change-password-container">
        <h1 class="text-center">Change Password</h1>
        <?php if (!empty($message)) echo $message; // Display message if set ?>
        <form action="admin_change_password.php" method="post">
            <div class="form-group">
                <label for="current_password">Current Password:</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>
            <div class="form-group mt-3">
                <label for="new_password">New Password:</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="form-group mt-3">
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" name="change_password" class="btn btn-primary btn-block">Change Password</button>
        </form>
    </div>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php include 'admin_Footer.php'; // Include footer ?>
