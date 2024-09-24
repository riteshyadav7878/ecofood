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
        .error-placeholder {
            color: red !important;
        }
        .error-border {
            border: 1px solid red !important;
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
                    <form class="theme-form" id="registerForm" action="register.php" method="post">
                        <input class="theme-input-text" type="text" id="username" name="username" placeholder="Username" required />
                        <input class="theme-input-text" type="email" id="email" name="email" placeholder="Email" required />
                        <input class="theme-input-text" type="password" id="password" name="password" placeholder="Password" required />
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
    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendor/retinajs/dist/retina.min.js"></script>
    <script src="vendor/SmoothScroll/SmoothScroll.js"></script>
    <script src="js/switcher-custom.js"></script>
    <script src="js/owl-custom.js"></script>
    <script src="js/main.js"></script>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            // Get form inputs
            var username = document.getElementById('username');
            var email = document.getElementById('email');
            var password = document.getElementById('password');
            var isValid = true;

            // Function to set error style
            function setError(input) {
                input.classList.add('error-border');
                input.placeholder = input.getAttribute('data-error');
                input.classList.add('error-placeholder');
                isValid = false;
            }

            // Function to reset error style
            function resetError(input) {
                input.classList.remove('error-border');
                input.placeholder = input.getAttribute('data-original-placeholder');
                input.classList.remove('error-placeholder');
            }

            // Validate inputs
            [username, email, password].forEach(function(input) {
                // Set original placeholder to revert back if valid
                if (!input.getAttribute('data-original-placeholder')) {
                    input.setAttribute('data-original-placeholder', input.placeholder);
                }
                // Set error message in placeholder
                input.setAttribute('data-error', 'This field is required');

                if (input.value.trim() === '') {
                    setError(input);
                } else {
                    resetError(input);
                }
            });

            // Prevent form submission if validation fails
            if (!isValid) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
