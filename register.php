<?php
session_name("user_session");
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
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = $conn->real_escape_string(trim($_POST['password']));
    $receive_email_updates = isset($_POST['email-updates']) ? 1 : 0;

    // Check if email already exists
    $result = $conn->query("SELECT id FROM user WHERE email = '$email'");
    if ($result->num_rows > 0) {
        $error_message = "Email is already registered.";
    } else {
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
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
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
        .error-message {
            color: red;
            font-size: 0.875em;
            display: block;
            margin-top: 0.25em;
        }

        .theme-input-text.error {
            border: 1px solid red;
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
                        <?php if (isset($error_message)) : ?>
                            <div class="alert alert-danger">
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>
                        <form id="registration-form" class="theme-form" action="register.php" method="post">
                            <div class="form-group">
                                <input id="username" class="theme-input-text" type="text" name="username" placeholder="Username" />
                                <span id="username-error" class="error-message"></span>
                            </div>
                            <div class="form-group">
                                <input id="email" class="theme-input-text" type="email" name="email" placeholder="Email" />
                                <span id="email-error" class="error-message"></span>
                            </div>
                            <div class="form-group">
                                <input id="password" class="theme-input-text" type="password" name="password" placeholder="Password" />
                                <span id="password-error" class="error-message"></span>
                            </div>
                            <div class="theme-checkbox">
                                <div class="item theme-input-chk">
                                    <input type="checkbox" id="privacy" name="privacy" />
                                    <label for="privacy"></label>
                                    <span>I have read and agree to the Privacy Policy</span>
                                    <span id="privacy-error" class="error-message"></span>
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
        document.getElementById('registration-form').addEventListener('submit', function(event) {
            let isValid = true;

            // Clear previous errors
            const errorElements = document.querySelectorAll('.error-message');
            errorElements.forEach(element => element.textContent = '');

            const inputs = document.querySelectorAll('.theme-input-text');
            inputs.forEach(input => input.classList.remove('error'));

            // Username validation
            const username = document.getElementById('username').value.trim();
            if (username === '') {
                document.getElementById('username-error').textContent = 'Username is required.';
                document.getElementById('username').classList.add('error');
                isValid = false;
            }

            // Email validation
            const email = document.getElementById('email').value.trim();
            if (email === '') {
                document.getElementById('email-error').textContent = 'Email is required.';
                document.getElementById('email').classList.add('error');
                isValid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                document.getElementById('email-error').textContent = 'Invalid email address.';
                document.getElementById('email').classList.add('error');
                isValid = false;
            }

            // Password validation
            const password = document.getElementById('password').value.trim();
            if (password === '') {
                document.getElementById('password-error').textContent = 'Password is required.';
                document.getElementById('password').classList.add('error');
                isValid = false;
            }

            // Privacy Policy checkbox validation
            const privacyChecked = document.getElementById('privacy').checked;
            if (!privacyChecked) {
                document.getElementById('privacy-error').textContent = 'You must agree to the Privacy Policy.';
                document.getElementById('privacy').classList.add('error');
                isValid = false;
            }

            // Prevent form submission if invalid
            if (!isValid) {
                event.preventDefault();
            }
        });
    </script>
</body>

</html>