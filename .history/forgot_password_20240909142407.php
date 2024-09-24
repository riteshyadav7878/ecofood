<?php
// Start session
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'ecofood');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$reset_status = "";
$token = isset($_GET['token']) ? $conn->real_escape_string(trim($_GET['token'])) : '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $conn->real_escape_string(trim($_POST['token']));
    $new_password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);

    // Verify token
    $sql = "SELECT * FROM user WHERE reset_token = '$token' AND reset_expiry > NOW()";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Update password and clear the token
        $sql = "UPDATE user SET password = '$new_password', reset_token = NULL, reset_expiry = NULL WHERE reset_token = '$token'";
        if ($conn->query($sql) === TRUE) {
            $reset_status = "Password has been updated successfully.";
        } else {
            $reset_status = "Error updating password: " . $conn->error;
        }
    } else {
        $reset_status = "Invalid or expired token.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        
        <?php if (empty($reset_status) && !empty($token)): ?>
            <form method="post">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <div class="form-group">
                    <label for="password">New Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        <?php endif; ?>
        
        <?php if (!empty($reset_status)): ?>
            <div class="alert alert-info mt-3">
                <?php echo htmlspecialchars($reset_status); ?>
            </div>
        <?php endif; ?>
    </div>
    
    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
