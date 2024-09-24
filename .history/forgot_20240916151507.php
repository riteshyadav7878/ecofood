<?php
session_name("user_session");
session_start();

include 'conn.php';

$error = '';
$success = '';
$token = '';

// Handle form submission for generating a reset token
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string(trim($_POST['email']));

    // Check if the email exists in the database
    $sql = "SELECT id FROM user WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        // Generate a unique token
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token valid for 1 hour

        // Insert token into the database
        $sql = "INSERT INTO password_reset (email, token, expiry) VALUES ('$email', '$token', '$expiry')";
        if ($conn->query($sql) === TRUE) {
            $success = "A password reset link has been generated.";
        } else {
            $error = "Failed to generate the reset link.";
        }
    } else {
        $error = "Email not found.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <style>
        .error-message { color: red; }
        .success-message { color: green; }
        .token-display { background: #f9f9f9; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
    </style>
</head>
<body>
    <h2>Forgot Password</h2>
    <form method="POST" action="forgot.php">
        <input type="email" name="email" placeholder="Enter your email" required />
        <button type="submit">Send Reset Link</button>
    </form>
    
    <?php if (!empty($error)): ?>
        <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if (!empty($success)): ?>
        <div class="success-message"><?php echo $success; ?>
            <?php if (!empty($token)): ?>
                <div class="token-display">
                    <strong>Reset Token:</strong> <?php echo htmlspecialchars($token); ?>
                </div>
                <a href="reset_password.php?token=<?php echo htmlspecialchars($token); ?>">Go to Reset Page</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</body>
</html>
