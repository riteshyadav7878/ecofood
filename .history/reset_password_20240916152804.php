<?php
session_name("user_session");
session_start();

include 'conn.php';

$error = '';
$success = '';
$validToken = false;
$token = '';
$newPassword = '';

// Handle form submission for password reset
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['token']) && !empty($_POST['new_password'])) {
        $token = $conn->real_escape_string(trim($_POST['token']));
        $newPassword = password_hash($conn->real_escape_string(trim($_POST['new_password'])), PASSWORD_DEFAULT);

        // Validate the token
        $sql = "SELECT * FROM password_reset WHERE token = '$token'";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            $record = $result->fetch_assoc();
            $expiry = $record['expiry'];
            if (strtotime($expiry) > time()) {
                // Fetch email associated with the token
                $email = $record['email'];

                // Update user's password
                $sql = "UPDATE user SET password = '$newPassword' WHERE email = '$email'";
                if ($conn->query($sql) === TRUE) {
                    // Remove the used token
                    $sql = "DELETE FROM password_reset WHERE token = '$token'";
                    $conn->query($sql);

                    $success = "Password successfully updated.";
                } else {
                    $error = "Failed to update password.";
                }
            } else {
                $error = "Token has expired.";
            }
        } else {
            $error = "Token not found.";
        }
    } else {
        $error = "Please provide both token and new password.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <style>
        .error-message { color: red; }
        .success-message { color: green; }
    </style>
</head>
<body>
    <h2>Reset Password</h2>
    <form method="POST" action="reset_password.php">
        <div>
            <label for="token">Token:</label>
            <input type="text" id="token" name="token" value="<?php echo htmlspecialchars($token); ?>" required />
        </div>
        <div>
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required />
        </div>
        <button type="submit">Reset Password</button>
    </form>
    
    <?php if (!empty($error)): ?>
        <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if (!empty($success)): ?>
        <div class="success-message"><?php echo $success; ?></div>
    <?php endif; ?>
</body>
</html>
