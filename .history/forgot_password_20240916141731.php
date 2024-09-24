<?php
session_start();
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string(trim($_POST['email']));

    // Check if the email exists in the database
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $token = bin2hex(random_bytes(50));
        $expires = date('U') + 1800; // Token expires in 30 minutes

        // Insert token into database
        $sql = "INSERT INTO password_resets (email, token, expires) VALUES ('$email', '$token', '$expires')";
        if ($conn->query($sql)) {
            $resetLink = "http://yourdomain.com/reset_password.php?token=$token";

            // Send email to user
            $to = $email;
            $subject = "Password Reset Request";
            $message = "Click the following link to reset your password: $resetLink";
            $headers = "From: no-reply@yourdomain.com\r\n";
            mail($to, $subject, $message, $headers);

            echo "<div class='alert alert-success'>Password reset link has been sent to your email.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>No account found with that email address.</div>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <!-- Add CSS and JS here -->
</head>
<body>
    <form method="POST" action="forgot_password.php">
        <label for="email">Enter your email:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Send Reset Link</button>
    </form>
</body>
</html>
