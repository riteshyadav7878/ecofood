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
        .error-message {
            color: red;
            font-size: 0.9em;
            display: block;
            margin-top: 5px;
        }

        .theme-input-text.error {
            border: 1px solid red;
        }
    </style>
    
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
        <!-- Header content here -->
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
                        <form class="theme-form" action="register.php" method="post" id="registerForm">
                            <input class="theme-input-text" type="text" name="username" id="username" placeholder="Username" required />
                            <span class="error-message" id="usernameError"></span>
                            
                            <input class="theme-input-text" type="email" name="email" id="email" placeholder="Email" required />
                            <span class="error-message" id="emailError"></span>
                            
                            <input class="theme-input-text" type="password" name="password" id="password" placeholder="Password" required />
                            <span class="error-message" id="passwordError"></span>
                            
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
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            var valid = true;

            // Get input fields
            var username = document.getElementById('username');
            var email = document.getElementById('email');
            var password = document.getElementById('password');
            
            // Get error message spans
            var usernameError = document.getElementById('usernameError');
            var emailError = document.getElementById('emailError');
            var passwordError = document.getElementById('passwordError');

            // Clear previous error messages and border styles
            usernameError.textContent = '';
            emailError.textContent = '';
            passwordError.textContent = '';
            username.classList.remove('error');
            email.classList.remove('error');
            password.classList.remove('error');

            // Validation
            if (username.value.trim() === '') {
                valid = false;
                usernameError.textContent = 'Username is required';
                username.classList.add('error');
            }
            
            if (email.value.trim() === '') {
                valid = false;
                emailError.textContent = 'Email is required';
                email.classList.add('error');
            }
            
            if (password.value.trim() === '') {
                valid = false;
                passwordError.textContent = 'Password is required';
                password.classList.add('error');
            }

            // Prevent form submission if not valid
            if (!valid) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
