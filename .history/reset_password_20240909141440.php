<?php
session_start();
// Database connection
$conn = new mysqli('localhost', 'root', '', 'ecofood');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $conn->real_escape_string(trim($_POST['token']));
    $new_password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    // Verify token
    $sql = "SELECT * FROM user WHERE reset_token = '$token' AND reset_expiry > NOW()";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Update password
        $sql = "UPDATE user SET password = '$new_password', reset_token = NULL, reset_expiry = NULL WHERE reset_token = '$token'";
        $conn->query($sql);

        echo "Password has been updated.";
    } else {
        echo "Invalid or expired token.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form method="post">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
