<?php
session_name("user_session");
session_start();

include 'conn.php';

// Token from URL
$token = isset($_GET['token']) ? $conn->real_escape_string($_GET['token']) : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate the token and passwords
    if (empty($token) || empty($new_password) || empty($confirm_password)) {
        $message = "All fields are required.";
    } elseif ($new_password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        // Fetch the user associated with the token
        $sql = "SELECT * FROM user WHERE reset_token = '$token' AND token_expiry > NOW()";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the user's password and clear the reset token
            $sql = "UPDATE user SET password = '$hashed_password', reset_token = NULL, token_expiry = NULL WHERE reset_token = '$token'";
            $conn->query($sql);

            $message = "Password has been successfully reset. You can now <a href='login.php'>log in</a>.";
        } else {
            $message = "Invalid or expired token.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <!-- Add your CSS and other head elements here -->
    <style>
        .error-message {
            color: red;
            font-size: 0.875em;
            margin-top: 0.25em;
        }
    </style>
</head>
<body>
    <form method="POST" action="reset_password.php?token=<?php echo htmlspecialchars($token); ?>">
        <div>
            <input type="password" name="new_password" placeholder="New Password" required>
        </div>
        <div>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        </div>
        <button type="submit">Reset Password</button>
    </form>
    <?php if (isset($message)): ?>
        <div class="error-message"><?php echo $message; ?></div>
    <?php endif; ?>
</body>
</html>
