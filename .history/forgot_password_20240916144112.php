<?php
session_name("user_session");
session_start();

include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string(trim($_POST['email']));

    // Generate a reset token
    $token = bin2hex(random_bytes(50));
    $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

    // Check if email exists in the database
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Store the token and expiry in the database
        $sql = "UPDATE user SET reset_token = '$token', token_expiry = '$expiry' WHERE email = '$email'";
        $conn->query($sql);

        // Send email with the reset token
        $resetLink = "http://yourwebsite.com/reset_password.php?token=$token";
        $to = $email;
        $subject = "Password Reset Request";
        $message = "Please click the following link to reset your password: <a href='$resetLink'>$resetLink</a>";
        $headers = "From: no-reply@yourwebsite.com";

        if (mail($to, $subject, $message, $headers)) {
            $message = "A password reset link has been sent to your email address.";
        } else {
            $message = "Failed to send the email.";
        }
    } else {
        $message = "Email address not found.";
    }

    // Display the token for debugging (remove this in production)
    echo "Debug Token: $token";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <!-- Add your CSS and other head elements here -->
</head>
<body>
    <form method="POST" action="forgot_password.php">
        <div>
            <input type="email" name="email" placeholder="Enter your email" required>
        </div>
        <button type="submit">Send Reset Link</button>
    </form>
    <?php if (isset($message)): ?>
        <div><?php echo $message; ?></div>
    <?php endif; ?>
</body>
</html>
