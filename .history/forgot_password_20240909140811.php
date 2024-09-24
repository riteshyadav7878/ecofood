<?php
// Include database connection
include 'db_connection.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if the email exists
    $query = "SELECT id FROM user WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Generate a reset token and expiration time
        $token = bin2hex(random_bytes(32));
        $expires_at = date("Y-m-d H:i:s", strtotime('+1 hour'));

        // Store the token and expiration time in the database
        $query = "UPDATE user SET reset_token = ?, reset_expires_at = ? WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $token, $expires_at, $email);
        $stmt->execute();

        // Send reset email
        $reset_link = "http://yourdomain.com/reset_password.php?token=" . $token;
        $subject = "Password Reset Request";
        $message = "To reset your password, please click the link below:\n\n" . $reset_link;
        mail($email, $subject, $message);

        echo "A password reset link has been sent to your email.";
    } else {
        echo "No account found with that email address.";
    }
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password - Ecofood HTML5 Templates</title>
    <meta name="description" content="Forgot Password page">
    <meta name="author" content="AuCreative">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Add your stylesheets and scripts here -->
</head>
<body>
    <div class="page-content p-t-40 p-b-90">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-push-4">
                    <div class="login-1">
                        <h3>Forgot Password</h3>
                        <form method="POST" action="forgot_password.php">
                            <input class="theme-input-text" type="email" name="email" placeholder="Enter your email" required />
                            <button class="au-btn au-btn-border au-btn-radius btn-block btn-submit" type="submit">Send Reset Link</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
