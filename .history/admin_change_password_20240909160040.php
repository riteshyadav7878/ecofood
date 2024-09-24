<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
include('conn.php');
session_start(); // Start session

// Redirect to welcome page if user is already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin_index.php"); // Redirect to a logged-in area
    exit();
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_admin'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Use prepared statements for security
    if ($stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?")) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Set session variables
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['admin_logged_in'] = true; // Set login status
                header("Location: admin_index.php"); // Redirect to admin dashboard
                exit();
            } else {
                $login_error_message = "Invalid password.";
            }
        } else {
            $login_error_message = "No user found with that username.";
        }

        $stmt->close();
    } else {
        echo "Failed to prepare statement.";
    }
}

// Handle password change form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        $change_password_error_message = "You must be logged in to change your password.";
    } else {
        $old_password = trim($_POST['old_password']);
        $new_password = trim($_POST['new_password']);
        $admin_id = $_SESSION['admin_id'];

        if (empty($old_password) || empty($new_password)) {
            $change_password_error_message = "Please fill in all fields.";
        } else {
            // Get the current admin details
            if ($stmt = $conn->prepare("SELECT password FROM admin WHERE id = ?")) {
                $stmt->bind_param("i", $admin_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $admin = $result->fetch_assoc();
                    $current_password_hash = $admin['password'];

                    // Verify the old password
                    if (password_verify($old_password, $current_password_hash)) {
                        // Update the password
                        $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                        if ($update_stmt = $conn->prepare("UPDATE admin SET password = ? WHERE id = ?")) {
                            $update_stmt->bind_param("si", $hashed_new_password, $admin_id);
                            if ($update_stmt->execute()) {
                                $change_password_success_message = "Password changed successfully.";
                            } else {
                                $change_password_error_message = "Failed to update password.";
                            }
                            $update_stmt->close();
                        } else {
                            echo "Failed to prepare update statement.";
                        }
                    } else {
                        $change_password_error_message = "Old password is incorrect.";
                    }
                } else {
                    $change_password_error_message = "User not found.";
                }

                $stmt->close();
            } else {
                echo "Failed to prepare select statement.";
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login and Change Password</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background for the page */
        }
        .container {
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
    <div class="container">
        <?php if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) { ?>
            <h1 class="text-center">Admin Login</h1>
            <?php if (isset($login_error_message)) { ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($login_error_message); ?></div>
            <?php } ?>
            <form action="admin_change_password.php" method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" name="login_admin" class="btn btn-primary btn-block">Login</button>
            </form>
        <?php } else { ?>
            <h1 class="text-center">Change Password</h1>
            <?php if (isset($change_password_success_message)) { ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($change_password_success_message); ?></div>
            <?php } ?>
            <?php if (isset($change_password_error_message)) { ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($change_password_error_message); ?></div>
            <?php } ?>
            <form action="admin_change_password.php" method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" readonly>
                </div>
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
        <?php } ?>
    </div>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
