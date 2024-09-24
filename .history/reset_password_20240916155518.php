<?php
session_name("user_session");
session_start();

include 'conn.php';
// If the user is already logged in, redirect them to the protected page
if (isset($_SESSION['username'])) {
    header("Location: shop-list-without-sidebar.php");
    exit();
}

$error = '';
$success = '';
$validToken = false;
$token = '';
$newPassword = '';

// Handle form submission for password reset
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['token']) && !empty($_POST['new_password'])) {
        $token = $conn->real_escape_string(trim($_POST['token']));
        $newPassword = password_hash($conn->real_escape_string(trim($_POST['new_password'])), PASSWORD_DEFAULT);

        // Validate the token
        $sql = "SELECT * FROM password_reset WHERE token = '$token'";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            $record = $result->fetch_assoc();
            $expiry = $record['expiry'];
            if (strtotime($expiry) > time()) {
                // Fetch email associated with the token
                $email = $record['email'];

                // Update user's password
                $sql = "UPDATE user SET password = '$newPassword' WHERE email = '$email'";
                if ($conn->query($sql) === TRUE) {
                    // Remove the used token
                    $sql = "DELETE FROM password_reset WHERE token = '$token'";
                    $conn->query($sql);

                    $success = "Password successfully updated.";
                } else {
                    $error = "Failed to update password.";
                }
            } else {
                $error = "Token has expired.";
            }
        } else {
            $error = "Token not found.";
        }
    } else {
        $error = "Please provide both token and new password.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(45deg, #f3ec78, #af4261);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .error-message { color: red; }
        .success-message { color: green; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form method="POST" action="reset_password.php">
            <div class="form-group">
                <label for="token">Token:</label>
                <input type="text" id="token" name="token" class="form-control" value="<?php echo htmlspecialchars($token); ?>" required />
            </div>
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" class="form-control" required />
            </div>
            <button type="submit" class="btn btn-primary">Reset Password</button>
        </form>
        
        <?php if (!empty($error)): ?>
            <div class="error-message mt-3"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="success-message mt-3"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="mt-4">
            <a href="your-previous-page.php" class="btn btn-secondary">Go Back</a>
            <a href="generate_token.php" class="btn btn-info">Create Token</a>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
