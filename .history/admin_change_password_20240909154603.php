<?php
// Include database connection
include('conn.php');
session_start(); // Start session

// Redirect to login page if user is not logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $old_password = isset($_POST['old_password']) ? trim($_POST['old_password']) : '';
    $new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';

    // Ensure the old_password and new_password are not empty
    if (empty($old_password) || empty($new_password)) {
        $error_message = "Please fill in all fields.";
    } else {
        // Get the current admin details
        $admin_id = $_SESSION['admin_id']; // Ensure this matches your session variable name
        $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_id = ?"); // Update column name here
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verify the old password
            if (password_verify($old_password, $row['password'])) {
                // Update the password
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_stmt = $conn->prepare("UPDATE admin SET password = ? WHERE admin_id = ?"); // Update column name here
                $update_stmt->bind_param("si", $hashed_new_password, $admin_id);
                if ($update_stmt->execute()) {
                    $success_message = "Password changed successfully.";
                } else {
                    $error_message = "Failed to update password.";
                }
                $update_stmt->close();
            } else {
                $error_message = "Old password is incorrect.";
            }
        } else {
            $error_message = "User not found.";
        }

        $stmt->close();
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
            margin: 50px auto;
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
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container change-password-container">
        <h1 class="text-center">Change Password</h1>
        <?php if (isset($success_message)) { ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div>
        <?php } ?>
        <?php if (isset($error_message)) { ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
        <?php } ?>
        <form action="admin_change_password.php" method="post">
            <div class="form-group">
                <label for="old_password">Old Password:</label>
                <input type="password" class="form-control" id="old_password" name="old_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <button type="submit" name="change_password" class="btn btn-primary btn-block">Change Password</button>
        </form>
    </div>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
