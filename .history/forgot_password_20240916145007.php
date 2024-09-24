<?php
require 'conn.php'; // Database connection

// Initialize variables
$token = '';
$new_password = '';
$success_message = '';
$error_message = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['reset'])) {
        // Token form submitted
        $token = $_POST['token'];

        // Validate the token
        $stmt = $conn->prepare("SELECT id FROM password_resets WHERE token = ? AND expiry > NOW()");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $user_id = $user['id'];
            $token_valid = true;
        } else {
            $error_message = "Invalid or expired token.";
        }
    } elseif (isset($_POST['reset_password'])) {
        // Password reset form submitted
        $new_password = $_POST['new_password'];
        $token = $_POST['token']; // Ensure the token is still available

        if (!empty($token) && !empty($new_password)) {
            // Update the password
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("UPDATE users JOIN password_resets ON users.id = password_resets.user_id SET users.password = ? WHERE password_resets.token = ?");
            $stmt->bind_param("ss", $hashed_password, $token);
            $stmt->execute();

            // Delete the reset token
            $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();

            $success_message = "Password has been reset successfully.";
        } else {
            $error_message = "Please provide a new password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>

        <?php if (empty($token) || !isset($token_valid)): ?>
            <!-- Token submission form -->
            <form action="forgot_password.php" method="post">
                <label for="token">Reset Token:</label>
                <input type="text" id="token" name="token" required>
                <button type="submit" name="reset">Verify Token</button>
            </form>
        <?php else: ?>
            <!-- New password form -->
            <form action="forgot_password.php" method="post">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>
                <button type="submit" name="reset_password">Reset Password</button>
            </form>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <p style="color: green;"><?php echo htmlspecialchars($success_message); ?></p>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
