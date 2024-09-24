<?php
session_start(); // Start the session

// Include database connection
include('conn.php');

// Initialize message variable
$message = '';

// Handle password change
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    if (!isset($_SESSION['admin_id'])) {
        $message = '<div class="alert alert-danger" role="alert">Session admin_id is not set.</div>';
    } else {
        $current_password = trim($_POST['current_password']);
        $new_password = trim($_POST['new_password']);
        $confirm_password = trim($_POST['confirm_password']);
        $admin_id = $_SESSION['admin_id'];

        $sql = "SELECT * FROM admin WHERE admin_id='$admin_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            if (password_verify($current_password, $admin['password'])) {
                if ($new_password === $confirm_password) {
                    $hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);
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
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Change Password</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 500px;
            margin-top: 50px;
            padding: 30px;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        h1 {
            color: #343a40;
        }
        .form-group label {
            color: #495057;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!empty($message)) echo $message; ?>

        <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
            <h1 class="text-center">Change Password</h1>
            <form action="" method="post">
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
        <?php endif; ?>
    </div>

    <?php include 'admin_Footer.php'; ?>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
