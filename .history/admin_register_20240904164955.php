<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
include 'conn.php'; // Include your database connection file
include 'admin_Navbar.php'; // Include navbar

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register_admin'])) {
        $username = $conn->real_escape_string(trim($_POST['username']));
        $email = $conn->real_escape_string(trim($_POST['email']));
        $password = $conn->real_escape_string(trim($_POST['password']));

        // Password hashing for security
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert into database
        $sql = "INSERT INTO admin (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success'>New admin registered successfully</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Registration</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background for the page */
        }
        .register-container {
            max-width: 500px;
            margin-top: 50px;
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
        .error {
            border: 1px solid #dc3545; /* Red border for errors */
        }
        .error-message {
            color: #dc3545; /* Red color for error message */
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container register-container">
        <h1 class="text-center">Register New Admin</h1>
        <form id="registerForm" action="admin_register.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username">
                <div id="username-error" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email">
                <div id="email-error" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password">
                <div id="password-error" class="error-message"></div>
            </div>
            <button type="submit" name="register_admin" class="btn btn-primary btn-block">Register Admin</button>
        </form>
    </div>
    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            var form = event.target;
            var valid = true;
            var errorMessage = '';
            var inputs = form.querySelectorAll('input');
            var errorElement;
            
            console.log('Form submitted');
            
            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(function(el) {
                el.innerHTML = '';
            });
            document.querySelectorAll('input').forEach(function(el) {
                el.classList.remove('error');
            });

            inputs.forEach(function(input) {
                errorElement = document.getElementById(input.id + '-error');
                if (input.value.trim() === '') {
                    console.log(input.id + ' is empty');
                    input.classList.add('error');
                    errorElement.innerHTML = 'This field is required.';
                    valid = false;
                }
            });

            if (!valid) {
                event.preventDefault(); // Prevent form submission if invalid
            }
        });
    </script>
</body>
</html>

<?php include 'admin_Footer.php'; ?>
