<?php
session_name("user_session");
session_start();

include 'conn.php';

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string(trim($_POST['email']));
    
    // Check if the email exists
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Generate a unique token
        $token = bin2hex(random_bytes(16));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token valid for 1 hour

        // Save token and expiry to the database
        $sql = "INSERT INTO password_reset (email, token, expiry) VALUES ('$email', '$token', '$expiry')";
        if ($conn->query($sql) === TRUE) {
            // Send token to the user's email
            $resetLink = "http://yourdomain.com/reset_password.php?token=$token";
            $subject = "Password Reset Request";
            $message = "Click the following link to reset your password: $resetLink";
            mail($email, $subject, $message);

            $success = "A password reset link has been sent to your email.";
        } else {
            $error = "Failed to generate reset token.";
        }
    } else {
        $error = "No account found with that email address.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Generate Token</title>
    <style>
        .error-message { color: red; }
        .success-message { color: green; }
    </style>
</head>
<body>
    <h2>Forgot Password</h2>
    <form method="POST" action="generate_token.php">
        <input type="email" name="email" placeholder="Enter your email" required />
        <button type="submit">Send Reset Link</button>
    </form>
    <?php if (isset($error)): ?>
        <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="success-message"><?php echo $success; ?></div>
    <?php endif; ?>
</body>
</html>
