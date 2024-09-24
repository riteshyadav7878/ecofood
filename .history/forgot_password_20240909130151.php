<?php
// Start session
session_start();

// Include database connection
$conn = new mysqli('localhost', 'root', '', 'ecofood');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle password reset
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token is valid
    $sql = "SELECT * FROM user WHERE reset_token = '$token' AND reset_expires_at > NOW()";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $password = $conn->real_escape_string(trim($_POST['password']));
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Update password in the database
            $sql = "UPDATE user SET password = '$hashed_password', reset_token = NULL, reset_expires_at = NULL WHERE reset_token = '$token'";
            if ($conn->query($sql)) {
                echo "Password has been reset successfully. <a href='login.php'>Login now</a>";
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
        }
    } else {
        echo "This reset link has expired or is invalid.";
    }
} else {
    // Handle password reset request
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $conn->real_escape_string(trim($_POST['email']));

        // Check if the email exists in the database
        $sql = "SELECT * FROM user WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Generate a unique token for password reset
            $token = bin2hex(random_bytes(50));

            // Store the token in the database with an expiration date
            $expires_at = date("Y-m-d H:i:s", strtotime('+1 hour'));
            $sql = "UPDATE user SET reset_token='$token', reset_expires_at='$expires_at' WHERE email='$email'";
            $conn->query($sql);

            // Create a reset link
            $reset_link = "http://yourwebsite.com/forgot_password.php?token=$token";

            // Send the reset link via email (pseudo-code, replace with actual mail function)
            $to = $email;
            $subject = "Password Reset Request";
            $message = "Click the following link to reset your password: $reset_link";
            // mail($to, $subject, $message);

            echo "A password reset link has been sent to your email.";
        } else {
            echo "No account found with that email address.";
        }
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password - Ecofood</title>
    <link href="css/main.css" rel="stylesheet">
    <style>
        .container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($_GET['token'])): ?>
            <!-- Password Reset Form -->
            <h2>Reset Password</h2>
            <form action="forgot_password.php?token=<?php echo $_GET['token']; ?>" method="POST">
                <input type="password" name="password" placeholder="Enter new password" required>
                <button type="submit">Reset Password</button>
            </form>
        <?php else: ?>
            <!-- Password Reset Request Form -->
            <h2>Forgot Password</h2>
            <form action="forgot_password.php" method="POST">
                <input type="email" name="email" placeholder="Enter your email" required>
                <button type="submit">Send Reset Link</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
