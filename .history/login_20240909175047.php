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

    <link href="fonts/fonts.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/css-hamburgers/dist/hamburgers.min.css" rel="stylesheet">
    <link href="vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css" rel="stylesheet">
    <link href="vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/switcher.css" rel="stylesheet">
    <link href="css/colors/green.css" rel="stylesheet" id="colors">
    <link href="css/retina.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.png">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.png">
    <script src="js/modernizr-custom.js"></script>
</head>
<body>
    <div class="page-loader">
        <div class="loader"></div>
    </div>
    <div id="switcher">
        <!-- Switcher content here -->
    </div>
    <header>
        <div class="section dark-background">
            <div class="container">
                <div class="header-2">
                    <div class="header-left">
                        <p>
                            <i class="fa fa-map-marker"></i>256 Address Name, New York city
                            <span>|</span>
                            <i class="fa fa-clock-o"></i>07:30 Am - 11:00 Pm
                        </p>
                    </div>
                    <div class="header-right">
                        <div class="header-login">
                            <a href="login.php">
                                <i class="fa fa-user"></i>Log in</a>
                            <span>/</span>
                            <a href="register.php">Register</a>
                        </div>
                        <span class="divider">|</span>
                        <div class="header-search">
                            <button class="fa fa-search"></button>
                            <div class="search-box">
                                <input type="text" placeholder="Search..." />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
            <div class="row">
                <div class="col-md-4 col-md-push-4">
                    <div class="register-1 login-1">
                        <form class="theme-form" method="POST" action="login.php" onsubmit="return validateForm()">
                            <div class="input-group">
                                <input class="theme-input-text" type="text" id="username" name="username" placeholder="Username" />
                                <span id="usernameError" class="error-message" style="color:red;display:none;">Username is required</span>
                            </div>
                            <div class="input-group">
                                <input class="theme-input-text" type="password" id="password" name="password" placeholder="Password" />
                                <span id="passwordError" class="error-message" style="color:red;display:none;">Password is required</span>
                            </div>
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
                            <button class="au-btn au-btn-border au-btn-radius btn-block btn-submit" type="submit">LOG IN</button>
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

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendor/retinajs/dist/retina.min.js"></script>
    <script src="vendor/SmoothScroll/SmoothScroll.js"></script>
    <script src="js/switcher-custom.js"></script>
    <script src="js/owl-custom.js"></script>
    <script src="js/main.js"></script>

    <script>
        function validateForm() {
            var username = document.getElementById("username");
            var password = document.getElementById("password");

            var usernameError = document.getElementById("usernameError");
            var passwordError = document.getElementById("passwordError");

            var valid = true;

            username.style.borderColor = "";
            password.style.borderColor = "";
            usernameError.style.display = "none";
            passwordError.style.display = "none";

            if (username.value.trim() === "") {
                username.style.borderColor = "red";
                usernameError.style.display = "block";
                valid = false;
            }

            if (password.value.trim() === "") {
                password.style.borderColor = "red";
                passwordError.style.display = "block";
                valid = false;
            }

            return valid;
        }
    </script>
</body>
</html>
