<?php
session_name("user_session");
session_start();

include 'conn.php';

$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPassword = $conn->real_escape_string(trim($_POST['new_password']));

    // Fetch the user by token
    $sql = "SELECT * FROM user WHERE reset_token = '$token' AND token_expiry > NOW()";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Hash the new password and update it in the database
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET password = '$hashedPassword', reset_token = NULL, token_expiry = NULL WHERE reset_token = '$token'";
        $conn->query($sql);

        $message = "Your password has been successfully updated.";
    } else {
        $message = "Invalid or expired token.";
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
</head>
<body>
    <form method="POST" action="reset_password.php?token=<?php echo htmlspecialchars($token); ?>">
        <div>
            <input type="password" name="new_password" placeholder="Enter your new password" required>
        </div>
        <button type="submit">Reset Password</button>
    </form>
    <?php if (isset($message)): ?>
        <div><?php echo $message; ?></div>
    <?php endif; ?>
</body>
</html>
