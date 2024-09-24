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
    <script src="js/modernizr-custom.js"></script>

    <style>
        input[type="text"], input[type="email"], input[type="password"] {
            border: 1px solid #ccc; /* Default border color */
            transition: border-color 0.3s ease;
        }
        input.invalid {
            border-color: red;
        }
        .error-message {
            color: red;
            display: none;
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
                        <i class="fa fa-clock-o"></i>07:30 Am - 11:00 Pm</p>
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
                        <form class="theme-form" action="register.php" method="post">
                            <input class="theme-input-text" type="text" name="username" placeholder="Username">
                            <input class="theme-input-text" type="email" name="email" placeholder="Email">
                            <input class="theme-input-text" type="password" name="password" placeholder="Password" required />
                            <div class="theme-checkbox">
                                <div class="item theme-input-chk">
                                    <input type="checkbox" id="privacy" required />
                                    <label for="privacy"></label>
                                    <span>I have read and agree to the Privacy Policy</span>
                                    <span class="error-message">You must agree to the Privacy Policy.</span>
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
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector("form");
        const inputs = form.querySelectorAll("input");
        const privacyCheckbox = form.querySelector("#privacy");

        form.addEventListener("submit", function(event) {
            let valid = true;

            // Remove existing error styles
            inputs.forEach(input => input.classList.remove("invalid"));

            if (!privacyCheckbox.checked) {
                privacyCheckbox.nextElementSibling.style.color = "red";
                valid = false;
            } else {
                privacyCheckbox.nextElementSibling.style.color = "";
            }

            inputs.forEach(input => {
                if (input.type !== "checkbox" && !input.value.trim()) {
                    input.classList.add("invalid");
                    valid = false;
                }
            });

            if (!valid) {
                event.preventDefault(); // Prevent form submission
            }
        });
    });
    </script>
</body>
</html>
