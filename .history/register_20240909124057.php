<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Ecofood HTML5 Templates</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/colors/green.css" rel="stylesheet" id="colors">
    <link rel="shortcut icon" href="favicon.png">
    <script src="js/modernizr-custom.js"></script>
    <style>
        /* Add red border when there's an error */
        .error-border {
            border-color: red;
        }

        /* Error message style */
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
            display: none;
        }
    </style>
</head>
<body>

<header>
    <!-- Header content here -->
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
</section>

<div class="page-content p-t-40 p-b-90">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-push-4">
                <div class="register-1">
                    <form id="register-form" class="theme-form" action="register.php" method="post">
                        <div>
                            <input class="theme-input-text" type="text" id="username" name="username" placeholder="Username" required />
                            <div class="error-message" id="username-error">Please enter a username.</div>
                        </div>
                        <div>
                            <input class="theme-input-text" type="email" id="email" name="email" placeholder="Email" required />
                            <div class="error-message" id="email-error">Please enter a valid email.</div>
                        </div>
                        <div>
                            <input class="theme-input-text" type="password" id="password" name="password" placeholder="Password" required />
                            <div class="error-message" id="password-error">Please enter a password.</div>
                        </div>
                        <div class="theme-checkbox">
                            <div class="item theme-input-chk">
                                <input type="checkbox" id="privacy" required />
                                <label for="privacy"></label>
                                <span>I have read and agree to the Privacy Policy</span>
                                <div class="error-message" id="privacy-error">You must agree to the Privacy Policy.</div>
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

<script>
    // JavaScript validation function
    document.getElementById('register-form').addEventListener('submit', function(event) {
        // Get form inputs
        var username = document.getElementById('username');
        var email = document.getElementById('email');
        var password = document.getElementById('password');
        var privacy = document.getElementById('privacy');
        
        var valid = true; // Flag to check form validity
        
        // Validate username
        if (username.value.trim() === '') {
            username.classList.add('error-border');
            document.getElementById('username-error').style.display = 'block';
            valid = false;
        } else {
            username.classList.remove('error-border');
            document.getElementById('username-error').style.display = 'none';
        }
        
        // Validate email
        if (email.value.trim() === '') {
            email.classList.add('error-border');
            document.getElementById('email-error').style.display = 'block';
            valid = false;
        } else {
            email.classList.remove('error-border');
            document.getElementById('email-error').style.display = 'none';
        }
        
        // Validate password
        if (password.value.trim() === '') {
            password.classList.add('error-border');
            document.getElementById('password-error').style.display = 'block';
            valid = false;
        } else {
            password.classList.remove('error-border');
            document.getElementById('password-error').style.display = 'none';
        }

        // Validate Privacy Policy checkbox
        if (!privacy.checked) {
            privacy.classList.add('error-border');
            document.getElementById('privacy-error').style.display = 'block';
            valid = false;
        } else {
            privacy.classList.remove('error-border');
            document.getElementById('privacy-error').style.display = 'none';
        }

        // Prevent form submission if any field is invalid
        if (!valid) {
            event.preventDefault();
        }
    });
</script>

<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
