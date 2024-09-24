<?php
session_start();
include 'conn.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token is valid
    $sql = "SELECT * FROM user WHERE reset_token = '$token' AND token_expires > NOW()";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $new_password = $conn->real_escape_string(trim($_POST['password']));
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password
            $conn->query("UPDATE user SET password = '$hashed_password', reset_token = NULL, token_expires = NULL WHERE id = $user_id");

            echo "Your password has been reset. You can now <a href='login.php'>login</a>.";
        }
    } else {
        echo "This link is invalid or has expired.";
    }
} else {
    echo "Invalid request.";
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
    <form method="POST" action="">
        <input type="password" name="password" placeholder="Enter new password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
