<?php
session_name("user_session");
session_start(); // Start the session

// Include database connection file
include 'conn.php';

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    header("Location: shop-list-without-sidebar.php");
    exit();
}
// Handling form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize input
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['msg']);

    // Insert form data into the database
    $sql = "INSERT INTO contact_submissions (name, email, message) VALUES ('$name', '$email', '$message')";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success'>Thank you for contacting us. We will get back to you soon.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</div>";
    }

    // Close the database connection
    mysqli_close($conn);
}

// Check if the logged-in user's account has been deleted
if (isset($_SESSION['user_id'])) {
    $user_id = intval($_SESSION['user_id']);
    $sql = "SELECT id FROM user WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) {
        // User's account has been deleted, destroy session and redirect to login page
        session_destroy();
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <meta name="description" content="Ecofood theme template">
    <meta name="author" content="AuCreative">
    <meta name="keywords" content="Ecofood theme template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Stylesheets -->
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
    <script>
        function validateContactForm() {
            var isValid = true;

            // Get input fields
            var name = document.querySelector("input[name='name']");
            var email = document.querySelector("input[name='email']");
            var message = document.querySelector("textarea[name='msg']");

            // Reset previous error styling
            name.style.borderColor = "";
            email.style.borderColor = "";
            message.style.borderColor = "";

            // Validate name
            if (name.value.trim() === "") {
                name.style.borderColor = "red";
                isValid = false;
            }

            // Validate email
            if (email.value.trim() === "") {
                email.style.borderColor = "red";
                isValid = false;
            }

            // Validate message
            if (message.value.trim() === "") {
                message.style.borderColor = "red";
                isValid = false;
            }

            return isValid;
        }

        // Attach the validation function to the form's onsubmit event
        document.addEventListener("DOMContentLoaded", function() {
            var form = document.querySelector("form[name='contactform']");
            if (form) {
                form.onsubmit = function() {
                    return validateContactForm();
                };
            }
        });
    </script>
</head>

<body>
    <div class="page-loader">
        <div class="loader"></div>
    </div>

    <!-- Color Switcher and Header -->
    <div id="switcher">
        <!-- Switcher Content Here -->
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
                    </div>
                </div>
            </div>
        </div>

    </header>

    <?php include 'Navbar.php'; ?>

    <!-- Contact Section -->
    <section>
        <div class="section primary-color-background">
            <div class="container">
                <div class="p-t-70 p-b-85">
                    <div class="heading-page-1">
                        <h3>Contact Us</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="section border-bottom-grey">
            <div class="container">
                <div class="breadcrumb-1">
                    <ul>
                        <li><a href="welcome.php">Home</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="page-content p-t-40 p-b-90">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <!-- Contact Information -->
                    <div class="contact-1">
                        <div class="contact-introduce">
                            <h4 class="title">Check here for the FAQ</h4>
                            <p>Get the details on commonly asked questions about us.</p>
                        </div>
                        <div class="contact-info">
                            <h4 class="title">Contact Information:</h4>
                            <!-- Contact Info Here -->
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Contact Form -->
                    <div class="get-in-touch">
                        <h4 class="title">LET'S GET IN TOUCH</h4>
                        <p>We're happy to answer questions or hear your feedback.</p>
                        <p>Just fill out the form below. We do our best to respond within 48 hours.</p>
                        <div class="add-comments-1">
                            <form class="submit-form" name="contactform" method="post" action="contact.php">
                                <div class="input-row m-b-20">
                                    <div class="p-r-5 input-col-5">
                                        <input type="text" name="name" placeholder="Your name *" />
                                    </div>
                                    <div class="p-l-5 input-col-5">
                                        <input type="email" name="email" placeholder="Your email *" />
                                    </div>
                                </div>
                                <div class="input-row">
                                    <textarea placeholder="Comment *" name="msg"></textarea>
                                </div>
                                <button class="au-btn au-btn-radius au-btn-border btn-submit-comments" type="submit">SUBMIT</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Content Here -->

    <?php include 'Footer.php'; ?>

    <!-- Back to Top -->
    <div id="up-to-top">
        <i class="fa fa-angle-up"></i>
    </div>

    <!-- Scripts -->
    <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendor/retinajs/dist/retina.min.js"></script>
    <script src="vendor/SmoothScroll/SmoothScroll.js"></script>
    <script src="js/switcher-custom.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY"></script>
    <script src="js/map-custom.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
