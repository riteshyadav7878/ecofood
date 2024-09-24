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
        $token = bin2hex(random_bytes(50)); // Generate a secure token
        $user_id = $user['id'];
        
        // Save token and expiration date in the database
        $expires_at = date("Y-m-d H:i:s", strtotime('+1 hour')); // Token valid for 1 hour
        $conn->query("UPDATE user SET reset_token = '$token', token_expires = '$expires_at' WHERE id = $user_id");
        
        // Send email to the user with a reset link
        $reset_link = "http://yourwebsite.com/reset_password.php?token=$token";
        $subject = "Password Reset Request";
        $message = "Hi, click on the following link to reset your password: $reset_link";
        mail($email, $subject, $message);

        $success = "A password reset link has been sent to your email.";
    } else {
        $error = "This email does not exist in our records.";
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
    <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
    <?php if (isset($success)) { echo "<p style='color: green;'>$success</p>"; } ?>
</body>
</html>
