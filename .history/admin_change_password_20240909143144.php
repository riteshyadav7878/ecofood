<?php
// Include database connection
include('conn.php');
session_start(); // Start session

// Redirect to login page if not logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php"); // Redirect to login page
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_details'])) {
    $new_username = trim($_POST['new_username']);
    $current_password = trim($_POST['current_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Fetch the current user details
    $stmt = $conn->prepare("SELECT * FROM admin WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['admin_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    // Verify current password
    if (!password_verify($current_password, $row['password'])) {
        $error_message = "Current password is incorrect.";
    } elseif ($new_password !== $confirm_password) {
        $error_message = "New passwords do not match.";
    } else {
        // Update username and password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE admin SET username = ?, password = ? WHERE id = ?");
        $stmt->bind_param("ssi", $new_username, $hashed_password, $_SESSION['admin_id']);
        if ($stmt->execute()) {
            $success_message = "Details updated successfully.";
            $_SESSION['username'] = $new_username; // Update session username
        } else {
            $error_message = "Error updating details.";
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
        <?php if (isset($error_message)) { ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
        <?php } ?>
        <?php if (isset($success_message)) { ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div>
        <?php } ?>
        <form action="admin_change_password.php" method="post">
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
    </div>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
