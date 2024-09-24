<?php

        
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include database connection file
include 'conn.php';

// Check if the form is submitted
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
?>

<!DOCTYPE html>
<!-- [if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
<meta charset="UTF-8">
<title>Contact - Ecofood html5 templates</title>
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
<link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.html">
<script src="js/modernizr-custom.js"></script>
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
            <p><i class="fa fa-map-marker"></i>256 Address Name, New York city <span>|</span> <i class="fa fa-clock-o"></i>07:30 Am - 11:00 Pm</p>
        </div>
        <div class="header-right">
            <div class="header-login">
                <a href="logout.php"><i class="fa fa-user"></i>Logout</a>
                
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

<?php include 'unavbar.php'; ?>

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
                <li><a href="index.php">Home</a></li>
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
                    <h4 class="title">Contact information:</h4>
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
                                <input type="text" name="name" placeholder="Your name *" required />
                            </div>
                            <div class="p-l-5 input-col-5">
                                <input type="email" name="email" placeholder="Your email *" required />
                            </div>
                        </div>
                        <div class="input-row">
                            <textarea placeholder="Comment *" name="msg" required></textarea>
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
