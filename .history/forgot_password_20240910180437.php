<?php
session_start();
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string(trim($_POST['email']));

    // Check if the email exists
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));

        // Set token expiration (1 hour from now)
        $expires_at = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Save the token and expiration time in the database
        $sql = "UPDATE user SET token='$token', token_expires_at='$expires_at' WHERE email='$email'";
        if ($conn->query($sql)) {
            // Send password reset email
            $reset_link = "http://yourwebsite.com/reset_password.php?token=$token";
            $subject = "Password Reset Request";
            $message = "Click the following link to reset your password: $reset_link";
            $headers = "From: no-reply@yourwebsite.com";

            mail($email, $subject, $message, $headers);

            echo "Password reset link has been sent to your email.";
        } else {
            echo "Error updating token. Please try again.";
        }
    } else {
        echo "Email does not exist.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>
    <form method="POST" action="forgot_password.php">
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
