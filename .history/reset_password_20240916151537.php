<?php
session_name("user_session");
session_start();

include 'conn.php';

$error = '';
$success = '';
$validToken = false;
$token = '';

// Check if the token is provided in the URL
if (isset($_GET['token'])) {
    $token = $conn->real_escape_string(trim($_GET['token']));
    $sql = "SELECT * FROM password_reset WHERE token = '$token'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $record = $result->fetch_assoc();
        $expiry = $record['expiry'];
        if (strtotime($expiry) > time()) {
            $validToken = true;
        } else {
            $error = "Token has expired.";
        }
    } else {
        $error = "Token not found.";
    }
}

// Handle form submission for password reset
if ($_SERVER["REQUEST_METHOD"] == "POST" && $validToken) {
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
        $error = "Failed to retrieve user email.";
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
    <?php if ($validToken): ?>
        <form method="POST" action="reset_password.php?token=<?php echo htmlspecialchars($token); ?>">
            <input type="password" name="new_password" placeholder="New Password" required />
            <button type="submit">Reset Password</button>
        </form>
    <?php else: ?>
        <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <div class="success-message"><?php echo $success; ?></div>
    <?php endif; ?>
</body>
</html>
