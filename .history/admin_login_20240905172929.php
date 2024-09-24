<?php
// Include database connection
include('conn.php');
session_start(); // Start session

// Redirect to welcome page if user is already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin_index.php"); // Redirect to a logged-in area
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_admin'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Use prepared statements for security
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['admin_logged_in'] = true; // Set login status
            header("Location: admin_index.php"); // Redirect to admin dashboard
            exit();
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "No user found with that username.";
    }

    $stmt->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background for the page */
        }
        .login-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            background-color: #ffffff; /* White background for the form */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }
        .btn-primary {
            background-color: #007bff; /* Bootstrap primary color */
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Darker shade for hover effect */
            border-color: #0056b3;
        }
        h1 {
            color: #343a40; /* Dark gray for heading */
        }
        .form-group label {
            color: #495057; /* Slightly dark gray for labels */
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
  

    <div class="container login-container">
        <h1 class="text-center">Admin Login</h1>
        <?php if (isset($error_message)) { ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
        <?php } ?>
        <form action="admin_login.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="login_admin" class="btn btn-primary btn-block">Login</button>
        </form>
    </div>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>

 
</body>
</html>
