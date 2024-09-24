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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="fonts/fonts.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/css-hamburgers/dist/hamburgers.min.css" rel="stylesheet">
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
    <header>
        <!-- Navbar and header content here -->
    </header>

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
                            <input class="theme-input-text" type="text" name="username" placeholder="Username" required />
                            <input class="theme-input-text" type="email" name="email" placeholder="Email" required />
                            <input class="theme-input-text" type="password" name="password" placeholder="Password" required />
                            <div id="password-strength"></div> <!-- Password strength display -->
                            <div class="theme-checkbox">
                                <div class="item theme-input-chk">
                                    <input type="checkbox" id="privacy" required />
                                    <label for="privacy"></label>
                                    <span>I have read and agree to the Privacy Policy</span>
                                </div>
                                <div class="item theme-input-chk">
                                    <input type="checkbox" id="email-updates" name="email-updates" />
                                    <label for="email-updates"></label>
                                    <span>Receive information about us via email</span>
                                </div>
                            </div>
                            <div>
                                <input type="checkbox" id="show-password" /> Show Password
                            </div>
                            <button class="au-btn au-btn-border au-btn-radius btn-block btn-submit" type="submit">REGISTER</button>
                        </form>
                        <div id="email-feedback"></div> <!-- Email update feedback display -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('.theme-form');
        const usernameInput = document.querySelector('input[name="username"]');
        const emailInput = document.querySelector('input[name="email"]');
        const passwordInput = document.querySelector('input[name="password"]');
        const privacyCheckbox = document.getElementById('privacy');
        const emailUpdatesCheckbox = document.getElementById('email-updates');
        const showPasswordCheckbox = document.getElementById('show-password');
        const passwordStrengthDiv = document.getElementById('password-strength');
        const emailFeedbackDiv = document.getElementById('email-feedback');
        
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

        // Password visibility toggle
        showPasswordCheckbox.addEventListener('change', function () {
            passwordInput.type = showPasswordCheckbox.checked ? 'text' : 'password';
        });

        // Email updates checkbox feedback
        emailUpdatesCheckbox.addEventListener('change', function () {
            emailFeedbackDiv.textContent = emailUpdatesCheckbox.checked 
                ? "You will receive email updates." 
                : "You have opted out of email updates.";
        });

        // Password strength indicator
        passwordInput.addEventListener('input', function () {
            const strength = checkPasswordStrength(passwordInput.value);
            passwordStrengthDiv.textContent = "Password strength: " + strength;
        });

        function checkPasswordStrength(password) {
            let strength = "Weak";
            if (password.length >= 8 && /[A-Z]/.test(password) && /[0-9]/.test(password)) {
                strength = "Strong";
            } else if (password.length >= 6) {
                strength = "Moderate";
            }
            return strength;
        }

        // Form validation
        form.addEventListener('submit', function (e) {
            let isValid = true;
            let errorMessage = "";

            if (usernameInput.value.trim() === "") {
                isValid = false;
                errorMessage += "Username is required.\n";
            }

            if (!emailPattern.test(emailInput.value.trim())) {
                isValid = false;
                errorMessage += "Please enter a valid email address.\n";
            }

            if (passwordInput.value.trim().length < 8) {
                isValid = false;
                errorMessage += "Password must be at least 8 characters long.\n";
            }

            if (!privacyCheckbox.checked) {
                isValid = false;
                errorMessage += "You must agree to the Privacy Policy.\n";
            }

            if (!isValid) {
                e.preventDefault(); // Prevent form from submitting
                alert(errorMessage); // Show error message to the user
            }
        });
    });
    </script>
</body>
</html>
