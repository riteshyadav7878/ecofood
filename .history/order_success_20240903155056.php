<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include your database connection file if needed
include 'conn.php';

// Check if the cart session exists
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty!";
    exit();
}

$total = 0;
?>
<!DOCTYPE html>

<!-- [if gt IE 8] <!-->
<html class="no-js" lang="en">
<!-- <![endif]-->

<!-- Mirrored from freebw.com/templates/ecofood/checkout.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 29 Aug 2024 05:33:27 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>

<meta charset="UTF-8">
<title>Order Success</title>
<meta name="description" content="Ecofood theme tempalte">
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
<link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.html">
<script src="js/modernizr-custom.js"></script>
 
</head>
<body>

<div class="page-loader">
<div class="loader"></div>
</div>
<div id="switcher">
<span class="switcher-cog"></span>
<div class="mCustomScrollbar" data-mcs-theme="minimal-dark">
<a class="btn-buy" href="https://themeforest.net/cart/add_items?item_ids=20283248&amp;ref=authemes" target="_blank">Buy Now</a>
<div class="clearfix"></div>
<div class="m-b-50"></div>
<span class="sw-title">Main Colors:</span>
<ul id="tm-color">
<li class="color1"></li>
<li class="color2"></li>
<li class="color3"></li>
<li class="color4"></li>
<li class="color5"></li>
<li class="color6"></li>
<li class="color7"></li>
</ul>
<div class="m-b-50"></div>
<span class="sw-title">HomePage Layout</span>
<ul class="demo-homepage">
<li>
<a href="index.php">
<img src="images/home_1.jpg" alt />
</a>
<img class="popup-demo-homepage" src="images/home_1.jpg" alt="Image" />
</li>
<li>
 
</ul>
</div>
</div>
<header>

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
<?php include 'Navbar.php'; ?>
 
<section>
<div class="section primary-color-background">
<div class="container">
<div class="p-t-70 p-b-85">

<div class="heading-page-1">
<h3>Thank You for Your Order!</h3>
</div>
</div>
</div>
</div>
<div class="section border-bottom-grey">
<div class="container">
<div class="breadcrumb-1">
<ul>
<li>
<a href="index.php">Home</a>
</li>
<li>
<a href="checkout.php">Order successfully</a>
</li>
</ul>
</div>
</div>
</div>
</section>
 
<div class="container">
        <h1>Thank You for Your Order!</h1>
        <p>Your order has been placed successfully. We will process it soon.</p>
        <a href="index.php" class="btn btn-primary">Continue Shopping</a>
    </div>
 
<?php include 'Footer.php'; ?>

<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
 
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vendor/retinajs/dist/retina.min.js"></script>
<script src="vendor/SmoothScroll/SmoothScroll.js"></script>
<script src="js/switcher-custom.js"></script>
<script src="js/main.js"></script>

</body>

<!-- Mirrored from freebw.com/templates/ecofood/checkout.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 29 Aug 2024 05:33:27 GMT -->
</html>