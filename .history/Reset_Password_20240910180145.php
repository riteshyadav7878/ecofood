<?php
session_start();
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];

    // Check if the token is valid and not expired
    $sql = "SELECT * FROM user WHERE token='$token' AND token_expires_at > NOW()";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the password and clear the token
        $sql = "UPDATE user SET password='$hashed_password', token=NULL, token_expires_at=NULL WHERE token='$token'";
        if ($conn->query($sql)) {
            echo "Password successfully updated.";
        } else {
            echo "Error updating password. Please try again.";
        }
    } else {
        echo "Invalid or expired token.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form method="POST" action="reset_password.php">
        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>" />
        <input type="password" name="new_password" placeholder="Enter new password" required />
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
