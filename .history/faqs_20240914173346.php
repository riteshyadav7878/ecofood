<?php
session_name("user_session");
session_start();
include 'conn.php';
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>

<!-- [if gt IE 8] <!-->
<html class="no-js" lang="en">
<!-- <![endif]-->

<!-- Mirrored from freebw.com/templates/ecofood/faqs.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 29 Aug 2024 05:33:30 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>

    <meta charset="UTF-8">
    <title>FAQs</title>
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

            </ul>
        </div>
    </div>


    <?php include 'Unavbar.php'; ?>

    <section>
        <div class="section primary-color-background">
            <div class="container">
                <div class="p-t-70 p-b-85">

                    <div class="heading-page-1">
                        <h3>FAQs</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="section border-bottom-grey">
            <div class="container">
                <div class="breadcrumb-1">
                    <ul>

                        <li>
                            <a href="faqs.php">FAQs</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="page-content p-t-40 p-b-100">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-push-2">

                    <div class="faqs-1">
                        <div data-accordion-group="data-accordion-group">
                            <div class="accordion open" data-accordion="data-accordion">
                                <div class="accordion-title" data-control="data-control">
                                    <h4>Do you have any dairy/casein free products?</h4>
                                </div>
                                <div class="accordion-content animated" data-content="data-content">
                                    <div class="content-inner">
                                        <p>Ut facilisis sed ante quis facilisis. Vestibulum magna mauris, vehicula id laoreet quis, tempus non lorem. Nulla bibendum massa sed pharetra blandit. Etiam venenatis nunc suscipit dolor placerat.</p>
                                        <p>Curabitur et lectus quam. Maecenas felis augue, suscipit sit amet nunc vitae, accumsan scelerisque sapien. Ut ultricies varius odio vel auctor.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion" data-accordion="data-accordion">
                                <div class="accordion-title" data-control="data-control">
                                    <h4>How will I get confirmation that my Order is placed successfully?</h4>
                                </div>
                                <div class="accordion-content animated" data-content="data-content">
                                    <div class="content-inner">
                                        <p>Ut facilisis sed ante quis facilisis. Vestibulum magna mauris, vehicula id laoreet quis, tempus non lorem. Nulla bibendum massa sed pharetra blandit. Etiam venenatis nunc suscipit dolor placerat.</p>
                                        <p>Curabitur et lectus quam. Maecenas felis augue, suscipit sit amet nunc vitae, accumsan scelerisque sapien. Ut ultricies varius odio vel auctor.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion" data-accordion="data-accordion">
                                <div class="accordion-title" data-control="data-control">
                                    <h4>How should I check the status of my Order?</h4>
                                </div>
                                <div class="accordion-content animated" data-content="data-content">
                                    <div class="content-inner">
                                        <p>Ut facilisis sed ante quis facilisis. Vestibulum magna mauris, vehicula id laoreet quis, tempus non lorem. Nulla bibendum massa sed pharetra blandit. Etiam venenatis nunc suscipit dolor placerat.</p>
                                        <p>Curabitur et lectus quam. Maecenas felis augue, suscipit sit amet nunc vitae, accumsan scelerisque sapien. Ut ultricies varius odio vel auctor.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion" data-accordion="data-accordion">
                                <div class="accordion-title" data-control="data-control">
                                    <h4>How do I return an item purchased from your website?</h4>
                                </div>
                                <div class="accordion-content animated" data-content="data-content">
                                    <div class="content-inner">
                                        <p>Ut facilisis sed ante quis facilisis. Vestibulum magna mauris, vehicula id laoreet quis, tempus non lorem. Nulla bibendum massa sed pharetra blandit. Etiam venenatis nunc suscipit dolor placerat.</p>
                                        <p>Curabitur et lectus quam. Maecenas felis augue, suscipit sit amet nunc vitae, accumsan scelerisque sapien. Ut ultricies varius odio vel auctor.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion" data-accordion="data-accordion">
                                <div class="accordion-title" data-control="data-control">
                                    <h4>How do I place my order & How do I receive my order?</h4>
                                </div>
                                <div class="accordion-content animated" data-content="data-content">
                                    <div class="content-inner">
                                        <p>Ut facilisis sed ante quis facilisis. Vestibulum magna mauris, vehicula id laoreet quis, tempus non lorem. Nulla bibendum massa sed pharetra blandit. Etiam venenatis nunc suscipit dolor placerat.</p>
                                        <p>Curabitur et lectus quam. Maecenas felis augue, suscipit sit amet nunc vitae, accumsan scelerisque sapien. Ut ultricies varius odio vel auctor.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include 'Footer.php'; ?>

    <!-- <footer>

<div class="footer-1 footer-2">
<div class="container">
<div class="row">
<div class="col-md-4 col-sm-4">
<div class="footer-introduce">
<div class="footer-logo">
<img src="images/icons/ic-logo-02.png" alt="logo ecofood" />
</div>
<div class="footer-intro">
<p>In vel auctor nunc, ut sodales tortor. Fusce venenatis sit amet mauris sed venenatis. Maecenas eu urna vitae ligula ornare eleifend in a lorem.</p>
</div>
</div>
</div>
<div class="col-md-4 col-sm-4">
<div class="footer-services">
<div class="footer-heading">
<h3>CUSTOMER SERVICES</h3>
</div>
<div class="row">
<div class="col-md-6">
<ul>
<li>
<a href="#">Product recall notices</a>
</li>
<li>
<a href="#">Order information</a>
</li>
<li>
<a href="#">Shipping & returns</a>
</li>
</ul>
</div>
<div class="col-md-6">
<ul>
<li>
<a href="#">Privacy policy</a>
</li>
<li>
<a href="#">Terms & conditions</a>
</li>
<li>
<a href="#">FAQs</a>
</li>
</ul>
</div>
</div>
</div>
</div>
<div class="col-md-4 col-sm-4">
<div class="footer-contact">
<div class="footer-heading">
<h3>CONTACT US</h3>
</div>
<ul>
<li>
<i class="fa fa-map-marker"></i>
<span>256 address name, New York city</span>
</li>
<li>
<i class="fa fa-clock-o"></i>
<span>7:30 Am - 11:00 Pm. Monday - Sunday</span>
</li>
<li>
<i class="fa fa-phone"></i>
<span>(044) 359 0173</span>
</li>
</ul>
</div>
</div>
</div>
<div class="footer-bottom">
<div class="footer-copyright">
<p>© 2017 Designed by AuThemes. All rights reserved.</p>
</div>
<ul class="footer-socials">
<li>
<a class="fa fa-facebook" href="#"></a>
</li>
<li>
<a class="fa fa-google-plus" href="#"></a>
</li>
<li>
<a class="fa fa-youtube" href="#"></a>
</li>
</ul>
</div>
</div>
</div>

</footer> -->
    <div id="up-to-top">
        <i class="fa fa-angle-up"></i>
    </div>


    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendor/retinajs/dist/retina.min.js"></script>
    <script src="vendor/SmoothScroll/SmoothScroll.js"></script>
    <script src="js/switcher-custom.js"></script>
    <script src="vendor/jquery-accordion/js/jquery.accordion.js"></script>
    <script src="js/accordion-custom.js"></script>
    <script src="js/main.js"></script>

</body>

<!-- Mirrored from freebw.com/templates/ecofood/faqs.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 29 Aug 2024 05:33:30 GMT -->

</html>