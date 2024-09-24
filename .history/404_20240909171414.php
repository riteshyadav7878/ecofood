<?php
session_start();
 include 'conn.php'
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

<!-- Mirrored from freebw.com/templates/ecofood/404.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 29 Aug 2024 05:33:28 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>

<meta charset="UTF-8">
<title>404 - Ecofood html5 templates</title>
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
<link href="vendor/toddish-popup/assets/css/popup.css" rel="stylesheet">
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
<a href="index-2.html">
<img src="images/home_1.jpg" alt />
</a>
<img class="popup-demo-homepage" src="images/home_1.jpg" alt="Image" />
</li>
<li>
<a href="index1.html">
<img src="images/home_2.jpg" alt />
</a>
<img class="popup-demo-homepage" src="images/home_2.jpg" alt="Image" />
</li>
<li>
<a href="index2.html">
<img src="images/home_3.jpg" alt />
</a>
<img class="popup-demo-homepage" src="images/home_3.jpg" alt="Image" />
</li>
<li>
<a href="index3.html">
<img src="images/home_4.jpg" alt />
</a>
<img class="popup-demo-homepage" src="images/home_4.jpg" alt="Image" />
</li>
</ul>
</div>
</div>
 

<?php include 'Unavbar.php'; ?>
<!-- <nav>

<div class="section white-background" id="js-navbar">
<div class="container">
<div class="nav-1 nav-2">
<button class="hamburger has-animation hamburger--collapse" id="toggle-icon">
<span class="hamburger-box">
<span class="hamburger-inner"></span>
</span>
</button>
<div class="logo">
<a href="index-2.html">
<img src="images/icons/ic-logo-01.png" alt="Ecofood" />
</a>
</div>
<div class="cart-icon-holder">
<div class="cart-shopping js-mini-shopcart">
<span class="totals">2</span>
<i class="fa fa-shopping-cart"></i>
</div>
</div>
<ul class="nav-menu">
<li class="has-drop">
<a class="has-text-color-hover" href="index-2.html">HOME</a>
<button class="btn-caret fa fa-angle-right"></button>
<ul class="drop-menu left">
<li>
<a class="has-bg-color-hover" href="index-2.html">Home 1</a>
</li>
<li>
<a class="has-bg-color-hover" href="index1.html">Home 2</a>
</li>
<li>
<a class="has-bg-color-hover" href="index2.html">Home 3</a>
</li>
<li>
<a class="has-bg-color-hover" href="index3.html">Home 4</a>
</li>
</ul>
</li>
<li class="has-drop">
<a class="has-text-color-hover" href="blog-list-with-sidebar-1.html">SHOP</a>
<button class="btn-caret fa fa-angle-right"></button>
<ul class="drop-menu left">
<li>
<a class="has-bg-color-hover" href="shop-categories.html">Shop categories</a>
</li>
<li>
<a class="has-bg-color-hover" href="shop-list-with-sidebar.html">Shop list 1</a>
</li>
<li>
<a class="has-bg-color-hover" href="shop-list-without-sidebar.html">Shop list 2</a>
</li>
<li>
<a class="has-bg-color-hover" href="shopping-cart.html">Shopping cart</a>
</li>
<li>
<a class="has-bg-color-hover" href="checkout.html">Check out</a>
</li>
<li>
<a class="has-bg-color-hover" href="wishlist-page.html">Wishlist Page</a>
</li>
<li>
<a class="has-bg-color-hover" href="product-details-1.html">Product Details</a>
</li>
</ul>
</li>
<li class="has-drop">
<a class="has-text-color-hover" href="about-1.html">ABOUT</a>
<button class="btn-caret fa fa-angle-right"></button>
<ul class="drop-menu left">
<li>
<a class="has-bg-color-hover" href="about-1.html">About 1</a>
</li>
<li>
<a class="has-bg-color-hover" href="about-2.html">About 2</a>
</li>
</ul>
</li>
<li class="has-drop">
<a class="has-text-color-hover" href="#">PAGES</a>
<button class="btn-caret fa fa-angle-right"></button>
<ul class="drop-menu left">
<li>
<a class="has-bg-color-hover" href="404.html">404 not found!</a>
</li>
<li>
<a class="has-bg-color-hover" href="faqs.html">FAQs</a>
</li>
<li>
<a class="has-bg-color-hover" href="login.html">Login</a>
</li>
<li>
<a class="has-bg-color-hover" href="register.html">Register</a>
</li>
</ul>
</li>
<li class="has-drop">
<a class="has-text-color-hover" href="blog-list-with-sidebar-1.html">BLOG</a>
<button class="btn-caret fa fa-angle-right"></button>
<ul class="drop-menu bottom-left">
<li class="has-drop">
<a class="has-bg-color-hover" href="blog-list-with-sidebar-1.html">BLog list</a>
<button class="btn-caret fa fa-angle-right"></button>
<ul class="drop-menu top-right">
<li>
<a class="has-bg-color-hover" href="blog-list-with-sidebar-1.html">Blog List 1</a>
</li>
<li>
<a class="has-bg-color-hover" href="blog-list-with-sidebar-2.html">Blog List 2</a>
</li>
<li>
<a class="has-bg-color-hover" href="blog-masonry.html">Blog List 3</a>
</li>
</ul>
</li>
<li class="has-drop">
<a class="has-bg-color-hover" href="blog-details-with-sidebar-1.html">Blog Details</a>
<button class="btn-caret fa fa-angle-right"></button>
<ul class="drop-menu top-right">
<li>
<a class="has-bg-color-hover" href="blog-details-with-sidebar-1.html">Blog Details 1</a>
</li>
<li>
<a class="has-bg-color-hover" href="blog-details-without-sidebar-1.html">Blog Details 2</a>
</li>
</ul>
</li>
</ul>
</li>
<li>
<a class="has-text-color-hover" href="contact.html">CONTACT</a>
</li>
</ul>
<div class="mini-shopcart">
<div class="head-mini-shopcart">
<p>2 items in your cart</p>
</div>
<div class="content-mini-shopcart">
<div class="item-mini-shopcart">
<div class="item-image">
<img src="images/shopping-cart-item-01.jpg" alt="shopping cart" />
</div>
<div class="item-content">
<h3 class="name">Strawberries, 16 oz</h3>
<p class="price">1 x $2.50</p>
<button class="btn-del fa fa-close"></button>
</div>
</div>
<div class="item-mini-shopcart">
<div class="item-image">
<img src="images/shopping-cart-item-02.jpg" alt="shopping cart" />
</div>
<div class="item-content">
<h3 class="name">Broccoli, bunch</h3>
<p class="price">2 x $4.00</p>
<button class="btn-del fa fa-close"></button>
</div>
</div>
</div>
<div class="foot-mini-shopcart">
<p class="total-shopcart">Total: $6.50</p>
<div class="mini-shopcart-action">
<button class="au-btn au-btn-border au-btn-radius btn-viewcart">VIEW CART</button>
<button class="au-btn au-btn-primary au-btn-radius btn-checkout">CHECK OUT</button>
</div>
</div>
</div>
</div>
</div>
</div>

</nav> -->
<section>
<div class="section grey-background p-t-150 p-b-150 full-screen">
<div class="container">
<div class="row">
<div class="col-md-6 col-md-push-3">

<div class="page-not-found-1">
<div class="page-not-found-title">
<h3>Opps! Page not found!</h3>
</div>
<div class="page-not-found-content">
<p>
We are sorry but the page you are looking for does not exist. You could return to
<span class="color">the homepage</span>or try the search box below.
</p>
</div>
<div class="page-not-found-search">
<input class="input-text" type="text" placeholder="Search..." />
<button class="fa fa-search" type="submit"></button>
</div>
<div class="page-not-found-image">
<img src="images/page-not-found-01.png" alt="paga not found" />
</div>
</div>

</div>
</div>
</div>
</div>
</section>
<footer></footer>
<div id="up-to-top">
<i class="fa fa-angle-up"></i>
</div>


<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vendor/retinajs/dist/retina.min.js"></script>
<script src="vendor/SmoothScroll/SmoothScroll.js"></script>
<script src="js/switcher-custom.js"></script>
<script src="vendor/toddish-popup/assets/js/jquery.popup.min.js"></script>
<script src="js/popup-custom.js"></script>
<script src="js/main.js"></script>

</body>

<!-- Mirrored from freebw.com/templates/ecofood/404.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 29 Aug 2024 05:33:30 GMT -->
</html>