<?php
include 'conn.php';

$error = '';
$success = '';
$validToken = false;

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the token is valid
if (isset($_GET['token'])) {
    $token = $conn->real_escape_string(trim($_GET['token']));
    $sql = "SELECT * FROM password_reset WHERE token = '$token' AND expiry > NOW()";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $validToken = true;
    } else {
        $error = "Invalid or expired token.";
    }
}

// Handling password reset
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($validToken) {
        $newPassword = password_hash($conn->real_escape_string(trim($_POST['new_password'])), PASSWORD_DEFAULT);

        // Fetch email associated with the token
        $sql = "SELECT email FROM password_reset WHERE token = '$token'";
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();
        $email = $user['email'];

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
        $error = "Invalid or expired token.";
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
    <?php if (isset($validToken) && $validToken): ?>
        <form method="POST" action="reset_password.php?token=<?php echo htmlspecialchars($token); ?>">
            <input type="password" name="new_password" placeholder="New Password" required />
            <button type="submit">Reset Password</button>
        </form>
    <?php else: ?>
        <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="success-message"><?php echo $success; ?></div>
    <?php endif; ?>
</body>
</html>
