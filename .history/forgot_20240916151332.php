<?php
include 'conn.php';

$error = '';
$success = '';
$validToken = false;
$token = '';

// Check if the token is provided in the URL
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

// Handle form submission for password reset
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($validToken) {
        $newPassword = password_hash($conn->real_escape_string(trim($_POST['new_password'])), PASSWORD_DEFAULT);

        // Fetch email associated with the token
        $sql = "SELECT email FROM password_reset WHERE token = '$token'";
        $result = $conn->query($sql);
        if ($result->num_rows === 1) {
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
            $error = "Failed to retrieve user information.";
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
        .form-container { max-width: 400px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        input[type="password"] { width: 100%; padding: 10px; margin: 5px 0; border: 1px solid #ddd; border-radius: 5px; }
        button { width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #218838; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Reset Password</h2>
        <?php if ($validToken): ?>
            <form method="POST" action="forgot.php?token=<?php echo htmlspecialchars($token); ?>">
                <input type="password" name="new_password" placeholder="New Password" required />
                <button type="submit">Reset Password</button>
            </form>
        <?php else: ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="success-message"><?php echo $success; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
