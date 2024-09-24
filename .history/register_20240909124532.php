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
            font-size: 14px;
            display: none;
            margin-top: 10px;
        }
        .error-border {
            border-color: red !important;
        }
    </style>
</head>
<body>
    <div class="page-loader">
        <div class="loader"></div>
    </div>

    <div id="switcher"></div>

    <header></header>

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
                        <input class="theme-input-text" type="text" name="username" placeholder="Username" required />
                        <input class="theme-input-text" type="email" name="email" placeholder="Email" required />
                        <input class="theme-input-text" type="password" name="password" placeholder="Password" required />
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
                        <span class="error-message" id="errorMessage">Please fill out all required fields.</span>
                        <button class="au-btn au-btn-border au-btn-radius btn-block btn-submit" type="submit">REGISTER</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Footer -->
    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendor/retinajs/dist/retina.min.js"></script>
    <script src="vendor/SmoothScroll/SmoothScroll.js"></script>
    <script src="js/switcher-custom.js"></script>
    <script src="js/owl-custom.js"></script>
    <script src="js/main.js"></script>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            // Get all required input fields
            var inputs = document.querySelectorAll('.theme-input-text[required]');
            var isValid = true;
            var errorMessage = document.getElementById('errorMessage');

            // Loop through each input to check if it's empty
            inputs.forEach(function(input) {
                if (input.value.trim() === '') {
                    isValid = false;
                    input.classList.add('error-border');  // Add red border to empty fields
                } else {
                    input.classList.remove('error-border');  // Remove red border if field is filled
                }
            });

            // Prevent form submission and show error message if form is invalid
            if (!isValid) {
                errorMessage.style.display = 'block';  // Show error message
                event.preventDefault();  // Prevent form from submitting
            } else {
                errorMessage.style.display = 'none';  // Hide error message
            }
        });
    </script>
</body>
</html>
