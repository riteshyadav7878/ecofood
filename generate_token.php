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
$token = '';

// Handle form submission for generating a reset token
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string(trim($_POST['email']));

    // Check if the email exists in the database
    $sql = "SELECT id FROM user WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        // Generate a shorter token
        $token = bin2hex(random_bytes(8)); // 16 characters
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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #aaffcc, #00cc99);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }
        .error-message { color: red; }
        .success-message { color: green; }
        .token-display { background: #f9f9f9; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Forgot Password</h2>
        <form method="POST" action="generate_token.php">
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Enter your email" required />
            </div>
            <button type="submit" class="btn btn-primary btn-block">Send Reset Link</button>
        </form>
        
        <?php if (!empty($error)): ?>
            <div class="error-message mt-3 text-center"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="success-message mt-3 text-center">
                <?php echo $success; ?>
                <?php if (!empty($token)): ?>
                    <div class="token-display mt-3">
                        <strong>Reset Token:</strong> <?php echo htmlspecialchars($token); ?>
                    </div>
                    <a href="reset_password.php?token=<?php echo htmlspecialchars($token); ?>" class="btn btn-info btn-block mt-3">Go to Reset Page</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
