<?php
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

<!-- Mirrored from freebw.com/templates/ecofood/blog-list-with-sidebar-1.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 29 Aug 2024 05:33:23 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>

<meta charset="UTF-8">
<title>Blog list with sidebar</title>
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
 <?php include 'Unavbar.php'; ?>
 
<section>
<div class="section primary-color-background">
<div class="container">
<div class="p-t-70 p-b-85">

<div class="heading-page-1">
<h3>Our Blog</h3>
</div>
</div>
</div>
</div>
<div class="section border-bottom-grey">
<div class="container">
<div class="breadcrumb-1">
<ul>
<li>
<a href="welcome.php">Home</a>
</li>
<li>
<a href="blog-list-with-sidebar-2.php">Our blog</a>
</li>
</ul>
</div>
</div>
</div>
</section>
<div class="page-content blog-list-page-1 p-t-40 p-b-100">
<div class="container">
<div class="row">
<div class="col-md-4 col-md-push-8">
<div class="p-l-15 page-sidebar">

<div class="search-widget-1">
<form class="search-form">
<input class="input-text" type="text" placeholder="Search products... " />
<span class="underline"></span>
<button class="input-submit fa fa-search" type="submit"></button>
</form>
</div>

<div class="m-t-30">

<div class="product-category-widget-1">
<div class="heading-widget">
<h3>PRODUCT CATEGORY</h3>
</div>
<ul class="product-category-list">
<li>
<a href="#">Fresh vegetables</a>
<span class="totals">(50)</span>
</li>
<li>
<a href="#">Apples</a>
<span class="totals">(10)</span>
</li>
<li>
<a href="#">Organic ingredients</a>
<span class="totals">(20)</span>
</li>
<li>
<a href="#">Sodas & juices</a>
<span class="totals">(10)</span>
</li>
<li>
<a href="#">Fresh vegetables</a>
<span class="totals">(50)</span>
</li>
<li>
<a href="#">Egg free mayo</a>
<span class="totals">(10)</span>
</li>
</ul>
</div>

</div>
<div class="m-t-40">

<div class="tags-widget-1">
<div class="heading-widget">
<h3>SEARCH BY TAGS</h3>
</div>
<ul class="tags-list">
<li>
<a href="#">Apples</a>
</li>
<li>
<a href="#">Organic juices</a>
</li>
<li>
<a href="#">Spinach</a>
</li>
<li>
<a href="#">Banana</a>
</li>
<li>
<a href="#">Soda</a>
</li>
<li>
<a href="#">Ingredients</a>
</li>
<li>
<a href="#">Fresh vegetables</a>
</li>
</ul>
</div>

</div>
<div class="m-t-50 m-b-30">

<div class="banner-widget-1">
<img src="images/sidebar-banner-01.jpg" alt="sidebar banner" />
<div class="banner-content">
<p>Start your path to exclusive savings</p>
<a href="#">Join now!</a>
</div>
</div>

</div>
</div>
</div>
<div class="col-md-8 col-md-pull-4">

<div class="blog-item-1">
<div class="blog-item-image">
<a href="#">
<img src="images/blog-item-04.jpg" alt="Make: A healthy and delicious St. Patrick’s day smoothie
" />
</a>
</div>
<div class="blog-item-title">
<h3 class="title">
<a href="#">Make: A healthy and delicious St. Patrick’s day smoothie
</a>
</h3>
</div>
<p class="blog-item-date">
<i class="fa fa-clock-o"></i>
<span>on April 28, 2017</span>
</p>
<p class="blog-item-content">Proin aliquet gravida nibh, in fringilla est eleifend et. Pellentesque hendrerit augue ut eros iaculis elementum. Donec porta efficitur lorem ut ultricies. Donec vulputate leo a enim dapibus sollicitudin. In sed mollis sapien,
in congue nulla. Mauris lorem nulla, tincidunt suscipit purus eu, dapibus semper lacus.
</p>
</div>

<div class="row">
<div class="col-md-6">

<div class="blog-item-1">
<div class="blog-item-image">
<a href="#">
<img src="images/blog-item-05.jpg" alt="Make: How to plant an organic garden
" />
</a>
</div>
<div class="blog-item-title">
<h3 class="title">
<a href="#">Make: How to plant an organic garden
</a>
</h3>
</div>
<p class="blog-item-date">
<i class="fa fa-clock-o"></i>
<span>on April 27, 2017</span>
</p>
</div>

</div>
<div class="col-md-6">

<div class="blog-item-1">
<div class="blog-item-image">
<a href="#">
<img src="images/blog-item-06.jpg" alt="Top 10 ingredients found everywhere across food industry
" />
</a>
</div>
<div class="blog-item-title">
<h3 class="title">
<a href="#">Top 10 ingredients found everywhere across food industry
</a>
</h3>
</div>
<p class="blog-item-date">
<i class="fa fa-clock-o"></i>
<span>on April 26, 2017</span>
</p>
</div>

</div>
<div class="col-md-6">

<div class="blog-item-1">
<div class="blog-item-image">
<a href="#">
<img src="images/blog-item-07.jpg" alt="Change: Recycle K-Cups in the garden!
" />
</a>
</div>
<div class="blog-item-title">
<h3 class="title">
<a href="#">Change: Recycle K-Cups in the garden!
</a>
</h3>
</div>
<p class="blog-item-date">
<i class="fa fa-clock-o"></i>
<span>on April 25, 2017</span>
</p>
</div>

</div>
<div class="col-md-6">

<div class="blog-item-1">
<div class="blog-item-image">
<a href="#">
<img src="images/blog-item-08.jpg" alt="News: We’re on YouTube!
" />
</a>
</div>
<div class="blog-item-title">
<h3 class="title">
<a href="#">News: We’re on YouTube!
</a>
</h3>
</div>
<p class="blog-item-date">
<i class="fa fa-clock-o"></i>
<span>on April 24, 2017</span>
</p>
</div>

</div>
</div>
<div class="m-t-50">

<div class="pagination-widget-1">
<ul class="pagination-list">
<li class="prev">
<a href="#">
<i class="fa fa-angle-left"></i>
<span>Previous</span>
</a>
</li>
<li class="item active">
<a href="#">
<span>1</span>
</a>
</li>
<li class="item">
<a href="#">
<span>2</span>
</a>
</li>
<li class="item">
<a href="#">
<span>3</span>
</a>
</li>
<li class="next">
<a href="#">
<span>Next</span>
<i class="fa fa-angle-right"></i>
</a>
</li>
</ul>
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
<script src="js/main.js"></script>

</body>

<!-- Mirrored from freebw.com/templates/ecofood/blog-list-with-sidebar-1.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 29 Aug 2024 05:33:24 GMT -->
</html>