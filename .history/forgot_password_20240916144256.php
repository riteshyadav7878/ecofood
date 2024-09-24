<?php
session_name("user_session");
session_start();

include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string(trim($_POST['email']));

    // Generate a shorter reset token
    $token = bin2hex(random_bytes(16)); // Generates a 32-character token
    $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

    // Check if email exists in the database
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Store the token and expiry in the database
        $sql = "UPDATE user SET reset_token = '$token', token_expiry = '$expiry' WHERE email = '$email'";
        $conn->query($sql);

        // You can add your email sending logic here if needed

        // Display the token for debugging
        echo "Debug Token: $token";
    } else {
        $message = "Email address not found.";
        echo $message;
    }
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
</body>
</html>
