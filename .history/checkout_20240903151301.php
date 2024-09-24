<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Combined Page - Ecofood</title>
    <meta name="description" content="Ecofood theme template">
    <meta name="author" content="AuCreative">
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

<!-- Switcher Section -->
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
            <li><a href="index.php"><img src="images/home_1.jpg" alt /></a><img class="popup-demo-homepage" src="images/home_1.jpg" alt="Image" /></li>
        </ul>
    </div>
</div>

<!-- Header Section -->
<header>
    <div class="section dark-background">
        <div class="container">
            <div class="header-2">
                <div class="header-left">
                    <p><i class="fa fa-map-marker"></i>256 Address Name, New York city <span>|</span> <i class="fa fa-clock-o"></i>07:30 Am - 11:00 Pm</p>
                </div>
                <div class="header-right">
                    <div class="header-login">
                        <a href="login.php"><i class="fa fa-user"></i>Log in</a><span>/</span><a href="register.php">Register</a>
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

<!-- Main Content Sections -->

<!-- Checkout Section -->
<section>
    <div class="section primary-color-background">
        <div class="container">
            <div class="p-t-70 p-b-85">
                <div class="heading-page-1">
                    <h3>Check out</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="section border-bottom-grey">
        <div class="container">
            <div class="breadcrumb-1">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="checkout.php">Check out</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Page Content -->
<div class="page-content p-t-40 p-b-90">
    <div class="container">
        <!-- Checkout Method -->
        <div class="checkout-1">
            <div class="checkout-method p-b-40 border-bottom-grey">
                <h4 class="checkout-heading">01 / Checkout method</h4>
                <p>If you have shopped with us before, please enter your details in the boxes below. If you are a new customer, please proceed to the Billing & Shipping section.</p>
                <form class="login-form">
                    <div class="input-row m-b-15">
                        <div class="input-col-5 p-r-5">
                            <input class="theme-input-text" type="text" placeholder="Username or Email" />
                        </div>
                        <div class="input-col-5 p-l-5">
                            <input class="theme-input-text" type="password" placeholder="Password" />
                        </div>
                    </div>
                    <button class="au-btn au-btn-radius au-btn-border" type="submit">LOG IN</button>
                    <a class="m-t-15" href="#">Lost your password?</a>
                </form>
            </div>

            <!-- Billing & Shipping Details -->
            <div class="checkout-bill-ship border-bottom-grey m-t-30 p-b-20">
                <!-- Additional Content (like Billing & Shipping Form) -->
            </div>
        </div>
    </div>
</div>

<!-- Footer Section -->
<footer>
    <!-- Footer Content -->
</footer>

<!-- Scripts -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="vendor/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="vendor/jquery-countTo/jquery.countTo.js"></script>
<script src="js/main.js"></script>

</body>
</html>
