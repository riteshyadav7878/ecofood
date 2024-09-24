<?php
// Include database connection
include 'db_connection.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $new_password = $_POST['password'];

    // Validate the token and get user data
    $query = "SELECT id FROM user WHERE reset_token = ? AND reset_expires_at > NOW()";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Update the password
        $query = "UPDATE user SET password = ?, reset_token = NULL, reset_expires_at = NULL WHERE reset_token = ?";
        $stmt = $conn->prepare($query);
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt->bind_param("ss", $hashed_password, $token);
        $stmt->execute();

        echo "Your password has been updated successfully.";
    } else {
        echo "Invalid or expired token.";
    }
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - Ecofood HTML5 Templates</title>
    <meta name="description" content="Reset Password page">
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
                        <h3>Reset Password</h3>
                        <form method="POST" action="reset_password.php">
                            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>" />
                            <input class="theme-input-text" type="password" name="password" placeholder="New Password" required />
                            <button class="au-btn au-btn-border au-btn-radius btn-block btn-submit" type="submit">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
