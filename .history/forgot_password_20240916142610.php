<?php
session_start();
include 'conn.php';

// Include PHPMailer library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; // Make sure you have installed PHPMailer via Composer

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string(trim($_POST['email']));

    // Check if email exists
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Generate token and expiry time
        $token = bin2hex(random_bytes(50));
        $expires = date('U') + 1800;

        // Insert token into password_resets table
        $sql = "INSERT INTO password_resets (email, token, expires) VALUES ('$email', '$token', '$expires')";
        if ($conn->query($sql)) {
            $resetLink = "http://yourdomain.com/reset_password.php?token=$token";

            // PHPMailer setup
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.yourserver.com'; // Set the SMTP server to send through
                $mail->SMTPAuth = true;
                $mail->Username = 'your-email@example.com'; // SMTP username
                $mail->Password = 'your-email-password'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('no-reply@yourdomain.com', 'Your Website');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $mail->Body    = "Click the following link to reset your password: <a href='$resetLink'>$resetLink</a>";

                $mail->send();
                echo "<div class='alert alert-success'>Password reset link has been sent to your email.</div>";
            } catch (Exception $e) {
                echo "<div class='alert alert-danger'>Mailer Error: {$mail->ErrorInfo}</div>";
            }
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
        .alert {
            margin-top: 1em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <form method="POST" action="forgot_password.php">
            <div class="form-group">
                <label for="email">Enter your email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Send Reset Link</button>
        </form>
    </div>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
