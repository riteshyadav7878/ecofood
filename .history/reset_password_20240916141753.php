<?php
session_start();
include 'conn.php';

if (isset($_GET['token'])) {
    $token = $conn->real_escape_string(trim($_GET['token']));

    // Check if the token is valid and not expired
    $sql = "SELECT * FROM password_resets WHERE token = '$token' AND expires > " . date('U');
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $password = $conn->real_escape_string(trim($_POST['password']));
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Get email from token
            $reset = $result->fetch_assoc();
            $email = $reset['email'];

            // Update the user's password
            $sql = "UPDATE user SET password = '$hashedPassword' WHERE email = '$email'";
            if ($conn->query($sql)) {
                // Delete the token
                $sql = "DELETE FROM password_resets WHERE token = '$token'";
                $conn->query($sql);

                echo "<div class='alert alert-success'>Password has been updated. You can now <a href='login.php'>log in</a>.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
            }
        }
    } else {
        echo "<div class='alert alert-danger'>Invalid or expired token.</div>";
    }

    $conn->close();
} else {
    echo "<div class='alert alert-danger'>No token provided.</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <!-- Add CSS and JS here -->
</head>
<body>
    <form method="POST" action="reset_password.php?token=<?php echo htmlspecialchars($_GET['token']); ?>">
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
