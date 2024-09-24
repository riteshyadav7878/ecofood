<?php
session_start();

include 'conn.php';
// If the user is already logged in, redirect them to the protected page
if (isset($_SESSION['username'])) {
    header("Location: shop-list-without-sidebar.php");
    exit();
}



// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $conn->real_escape_string(trim($_POST['username']));
    $password = $conn->real_escape_string(trim($_POST['password']));

    // SQL query to check if the user exists
    $sql = "SELECT * FROM user WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];

            // Redirect to a protected page (e.g., dashboard)
            header("Location: shop-list-without-sidebar.php");
            exit();
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Invalid username or password.";
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Ecofood HTML5 Templates</title>
    <meta name="description" content="Ecofood theme template">
    <meta name="author" content="AuCreative">
    <meta name="keywords" content="Ecofood theme template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS for responsiveness -->
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    
    <style>
        /* Error message style */
        .error-message {
            color: red;
            display: none;
        }
        .has-error {
            border-color: red !important;
        }
    </style>
</head>
<body>

    <header>
        <!-- Your header code -->
    </header>

    <?php include 'Navbar.php'; ?>

    <section>
        <div class="section primary-color-background">
            <div class="container">
                <div class="p-t-70 p-b-85">
                    <div class="heading-page-1">
                        <h3>My Account</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="section border-bottom-grey">
            <div class="container">
                <div class="breadcrumb-1">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="register.php">Register</a></li>
                        <li><a href="login.php">My Account</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="page-content p-t-40 p-b-90">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="register-1 login-1">
                        <!-- Form with action set to login_process.php -->
                        <form class="theme-form" method="POST" action="login_process.php" onsubmit="return validateForm()">
                            <!-- Username input field -->
                            <div class="input-group mb-3">
                                <input class="form-control" type="text" id="username" name="username" placeholder="Username" required />
                                <span id="usernameError" class="error-message">Username is required</span>
                            </div>
                            <!-- Password input field -->
                            <div class="input-group mb-3">
                                <input class="form-control" type="password" id="password" name="password" placeholder="Password" required />
                                <span id="passwordError" class="error-message">Password is required</span>
                            </div>
                            <!-- Checkbox and links -->
                            <div class="theme-checkbox">
                                <div class="item theme-input-chk">
                                    <input type="checkbox" id="remember-me" name="remember-me" />
                                    <label for="remember-me"></label>
                                    <span>Remember me</span>
                                </div>
                                <div class="item theme-input-chk">
                                    <input type="checkbox" id="forgot-password" />
                                    <label for="forgot-password"></label>
                                    <span><a href="forgot_password.php">Forgot your Password</a></span>
                                </div>
                            </div>
                            <!-- Submit button -->
                            <button class="btn btn-primary btn-block" type="submit">LOG IN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'Footer.php'; ?>

    <div id="up-to-top">
        <i class="fa fa-angle-up"></i>
    </div>

    <!-- Bootstrap and jQuery JS -->
    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendor/retinajs/dist/retina.min.js"></script>

    <script>
        function validateForm() {
            var username = document.getElementById("username");
            var password = document.getElementById("password");
            
            var usernameError = document.getElementById("usernameError");
            var passwordError = document.getElementById("passwordError");

            var valid = true;

            // Reset styles and hide errors
            username.classList.remove('has-error');
            password.classList.remove('has-error');
            usernameError.style.display = "none";
            passwordError.style.display = "none";

            // Validate username
            if (username.value.trim() === "") {
                username.classList.add('has-error');
                usernameError.style.display = "block";
                valid = false;
            }

            // Validate password
            if (password.value.trim() === "") {
                password.classList.add('has-error');
                passwordError.style.display = "block";
                valid = false;
            }

            // If fields are valid, allow form submission; else prevent it
            return valid;
        }
    </script>
</body>
</html>
