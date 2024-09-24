<?php
// Include database connection
include('conn.php');
session_start(); // Start session

// Initialize variables
$login_error_message = '';
$change_error_message = '';
$change_success_message = '';
$show_change_form = false;

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
                $_SESSION['admin_id'] = $row['admin_id']; // Ensure column name matches
                $_SESSION['username'] = $row['username'];
                $_SESSION['admin_logged_in'] = true; // Set login status
                $show_change_form = true;
            } else {
                $login_error_message = "Invalid password.";
            }
        } else {
            $login_error_message = "No user found with that username.";
        }
        $stmt->close();
    } else {
        $login_error_message = "Error preparing SQL statement.";
    }
}

// Handle password change form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_details']) && $show_change_form) {
    $new_username = trim($_POST['new_username']);
    $current_password = trim($_POST['current_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Check if admin_id is set
    if (!isset($_SESSION['admin_id'])) {
        $change_error_message = "User not logged in.";
    } else {
        // Fetch the current user details
        if ($stmt = $conn->prepare("SELECT * FROM admin WHERE admin_id = ?")) {
            $stmt->bind_param("i", $_SESSION['admin_id']);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Verify current password
                if (!password_verify($current_password, $row['password'])) {
                    $change_error_message = "Current password is incorrect.";
                } elseif ($new_password !== $confirm_password) {
                    $change_error_message = "New passwords do not match.";
                } else {
                    // Update username and password
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    if ($stmt = $conn->prepare("UPDATE admin SET username = ?, password = ? WHERE admin_id = ?")) {
                        $stmt->bind_param("ssi", $new_username, $hashed_password, $_SESSION['admin_id']);
                        if ($stmt->execute()) {
                            $change_success_message = "Details updated successfully.";
                            $_SESSION['username'] = $new_username; // Update session username
                        } else {
                            $change_error_message = "Error updating details.";
                            error_log("SQL Error: " . $stmt->error); // Log SQL errors
                        }
                        $stmt->close();
                    } else {
                        $change_error_message = "Error preparing SQL statement.";
                        error_log("SQL Preparation Error: " . $conn->error); // Log preparation errors
                    }
                }
            } else {
                $change_error_message = "User details not found.";
            }
        } else {
            $change_error_message = "Error preparing SQL statement.";
            error_log("SQL Preparation Error: " . $conn->error); // Log preparation errors
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
    <title>Admin Login / Change Password</title>
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
        <?php if ($show_change_form): ?>
            <h1 class="text-center">Change Password</h1>
            <?php if (!empty($change_error_message)) { ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($change_error_message); ?></div>
            <?php } ?>
            <?php if (!empty($change_success_message)) { ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($change_success_message); ?></div>
            <?php } ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="new_username">New Username:</label>
                    <input type="text" class="form-control" id="new_username" name="new_username" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="current_password">Current Password:</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password:</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" name="update_details" class="btn btn-primary btn-block">Update Details</button>
            </form>
        <?php else: ?>
            <h1 class="text-center">Admin Login</h1>
            <?php if (!empty($login_error_message)) { ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($login_error_message); ?></div>
            <?php } ?>
            <form action="" method="post">
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
        <?php endif; ?>
    </div>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
