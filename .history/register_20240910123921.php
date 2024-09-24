<!-- Backend -->
<?php
// Start session
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'ecofood');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $conn->real_escape_string(trim($_POST['username']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = $conn->real_escape_string(trim($_POST['password']));
    $receive_email_updates = isset($_POST['email-updates']) ? 1 : 0;

    // Password hashing for security
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // SQL query to insert data into the database
    $sql = "INSERT INTO user (username, email, password, receive_email_updates) 
            VALUES ('$username', '$email', '$hashed_password', $receive_email_updates)";

    // Execute query
    if ($conn->query($sql) === TRUE) {
        // Redirect to login page after successful registration
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Ecofood HTML5 Templates</title>
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

    <style>
        .error-border {
            border: 2px solid red;
        }
        .error-message {
            color: red;
            font-size: 0.875em;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="page-loader">
        <div class="loader"></div>
    </div>
    <div id="switcher">
        <!-- Switcher content here -->
    </div>
    <header>
        <!-- Header content here -->
    </header>
    <header>
        <!-- Navbar -->
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
                                <i class="fa fa-user"></i>Log in
                            </a>
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

    <!-- Include Navbar -->
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
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">My Account</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="page-content p-t-40 p-b-90">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-push-4">
                    <div class="register-1">
                        <form class="theme-form" action="register.php" method="post" onsubmit="return validateForm()">
                            <div class="form-group error-border">
                                <input id="username" class="theme-input-text" type="text" name="username" placeholder="Username" />
                                <div id="username-error" class="error-message"></div>
                            </div>
                            <div class="form-group">
                                <input id="email" class="theme-input-text" type="email" name="email" placeholder="Email" />
                                <div id="email-error" class="error-message"></div>
                            </div>
                            <div class="form-group">
                                <input id="password" class="theme-input-text" type="password" name="password" placeholder="Password" />
                                <div id="password-error" class="error-message"></div>
                            </div>
                            <div class="theme-checkbox">
                                <div class="item theme-input-chk">
                                    <input id="privacy" type="checkbox" name="privacy" />
                                    <label for="privacy"></label>
                                    <span>I have read and agree to the Privacy Policy</span>
                                    <div id="privacy-error" class="error-message"></div>
                                </div>
                                <div class="item theme-input-chk">
                                    <input type="checkbox" id="email-updates" name="email-updates" />
                                    <label for="email-updates"></label>
                                    <span>Receive information about us via email</span>
                                </div>
                            </div>
                            <button class="au-btn au-btn-border au-btn-radius btn-block btn-submit" type="submit">REGISTER</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Footer -->
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
            // Clear previous error messages and styles
            clearErrors();

            const username = document.getElementById("username").value;
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;
            const privacy = document.getElementById("privacy").checked;

            let valid = true;

            if (username.trim() === "") {
                showError("username", "Username must be filled out.");
                valid = false;
            }
            if (email.trim() === "" || !validateEmail(email)) {
                showError("email", "Please enter a valid email address.");
                valid = false;
            }
            if (password.trim() === "" || password.length < 6) {
                showError("password", "Password must be at least 6 characters long.");
                valid = false;
            }
            if (!privacy) {
                showError("privacy", "You must agree to the Privacy Policy.");
                valid = false;
            }

            return valid;
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(String(email).toLowerCase());
        }

        function showError(inputId, message) {
            const input = document.getElementById(inputId);
            const errorDiv = document.getElementById(inputId + "-error");
            input.classList.add("error-border");
            errorDiv.textContent = message;
        }

        function clearErrors() {
            const inputs = document.querySelectorAll(".theme-input-text");
            inputs.forEach(input => {
                input.classList.remove("error-border");
            });

            const errorDivs = document.querySelectorAll(".error-message");
            errorDivs.forEach(div => {
                div.textContent = "";
            });
        }
    </script>
</body>
</html>
