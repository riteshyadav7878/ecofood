<?php
session_start();
// Database connection
$conn = new mysqli('localhost', 'root', '', 'ecofood');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string(trim($_POST['username']));

    // SQL query to check if the user exists
    $sql = "SELECT * FROM user WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();

        // Generate a unique reset token
        $reset_token = bin2hex(random_bytes(32));
        $expiry_time = date("Y-m-d H:i:s", strtotime('+1 hour'));

        // Save token and expiry to database
        $sql = "UPDATE user SET reset_token = '$reset_token', reset_expiry = '$expiry_time' WHERE username = '$username'";
        $conn->query($sql);

        // Send reset email
        $reset_link = "http://yourdomain.com/reset-password.php?token=" . $reset_token;
        $to = $user['email'];
        $subject = "Password Reset Request";
        $message = "Hi " . $username . ",\n\nPlease click the link below to reset your password:\n" . $reset_link . "\n\nIf you did not request this, please ignore this email.";
        $headers = "From: no-reply@yourdomain.com";

        mail($to, $subject, $message, $headers);

        echo "A password reset link has been sent to your email.";
    } else {
        echo "No user found with that username.";
    }
}

$conn->close();
?>
