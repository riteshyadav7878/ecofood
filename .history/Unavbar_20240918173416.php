
<?php
 
// Check if the cart session exists and is not empty
$cart_empty = !isset($_SESSION['cart']) || empty($_SESSION['cart']);

// Calculate the total quantity of items in the cart
$total_quantity = $cart_empty ? 0 : array_sum(array_column($_SESSION['cart'], 'quantity'));
?>
<!DOCTYPE html>

<!-- [if gt IE 8] <!-->
<html class="no-js" lang="en">
<!-- <![endif]-->

<!-- Mirrored from freebw.com/templates/ecofood/index1.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 29 Aug 2024 05:33:16 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>

    <meta charset="UTF-8">
    <title>Homepage</title>
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
    <link href="vendor/revolution/css/layers.css" rel="stylesheet">
    <link href="vendor/revolution/css/navigation.css" rel="stylesheet">
    <link href="vendor/revolution/css/settings.css" rel="stylesheet">
    <link href="vendor/owl.carousel/dist/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/switcher.css" rel="stylesheet">
    <link href="css/colors/green.css" rel="stylesheet" id="colors">
    <link href="css/retina.css" rel="stylesheet">

    <link rel="shortcut icon" href="favicon.png">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.html">
    <script src="js/modernizr-custom.js"></script>

    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <style>
        /* Custom styles for cart icon */
        .cart-icon-holder {
            position: relative;
            display: inline-block;
        }

        .cart-item-count {
            position: absolute;
            top: -10px; /* Adjust this value as needed */
            right: -10px; /* Adjust this value as needed */
            background-color: red; /* Or any color you prefer */
            color: white;
            border-radius: 50%;
            width: 20px; /* Adjust size as needed */
            height: 20px; /* Adjust size as needed */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px; /* Adjust size as needed */
            font-weight: bold;
        }
    </style>
</head>

<body>

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
                            <a href="logout.php">
                                <i class="fa fa-user"></i>Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>

    <nav>

        <div class="section white-background" id="js-navbar">
            <div class="container">
                <div class="nav-1 nav-2">
                    <button class="hamburger has-animation hamburger--collapse" id="toggle-icon">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                    <div class="logo">
                        <a href="#">
                            <img src="images/icons/ic-logo-01.png" alt="Ecofood" />
                        </a>
                    </div>

                    <a href="cart.php">
        <div class="cart-icon-holder">
            <div class="cart-shopping js-mini-shopcart">
                <i class="fa fa-shopping-cart"></i>
                <?php if ($total_quantity > 0): ?>
                    <span class="cart-item-count"><?php echo $total_quantity; ?></span>
                <?php endif; ?>
            </div>
        </div>
    </a>


                    <ul class="nav-menu">

                        <li>
                            <a class="has-text-color-hover" href="welcome.php">Home</a>
                        </li>

                        <li class="has-drop">
                            <a class="has-text-color-hover" href="shop-list-without-sidebar.php">SHOP</a>
                            <button class="btn-caret fa fa-angle-right"></button>
                            <ul class="drop-menu left">
                                 <li>
                                    <a class="has-bg-color-hover" href="cart.php">Your cart</a>
                                </li>
                                <li>
                                    <a class="has-bg-color-hover" href="checkout.php">Check out</a>
                                </li>
 
                            </ul>

                        </li>

                        </li>
                         <li class="has-drop">
                            <a class="has-text-color-hover" href="#">PAGES</a>
                            <button class="btn-caret fa fa-angle-right"></button>
                            <ul class="drop-menu left">
                                <li>
                                    <a class="has-bg-color-hover" href="404.php">404 not found!</a>
                                </li>
                                <li>
                                    <a class="has-bg-color-hover" href="faqs.php">FAQs</a>
                                </li>
                                <li>
                                    <a class="has-bg-color-hover" href="logout.php">Logout</a>
                                </li>


                            </ul>
                        </li>

                        <li>
                            <a class="has-text-color-hover" href="contact1.php">CONTACT</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        </div>

    </nav>


    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendor/retinajs/dist/retina.min.js"></script>
    <script src="vendor/SmoothScroll/SmoothScroll.js"></script>
    <script src="js/switcher-custom.js"></script>
    <script src="vendor/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script src="vendor/revolution/js/jquery.themepunch.revolution.min.js"></script>
    <script src="vendor/owl.carousel/dist/owl.carousel.min.js"></script>

    <script type="text/javascript" src="vendor/revolution/js/extensions/revolution.extension.video.min.js"></script>
    <script type="text/javascript" src="vendor/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
    <script type="text/javascript" src="vendor/revolution/js/extensions/revolution.extension.actions.min.js"></script>
    <script type="text/javascript" src="vendor/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
    <script type="text/javascript" src="vendor/revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
    <script type="text/javascript" src="vendor/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
    <script type="text/javascript" src="vendor/revolution/js/extensions/revolution.extension.migration.min.js"></script>
    <script type="text/javascript" src="vendor/revolution/js/extensions/revolution.extension.parallax.min.js"></script>
    <script src="js/revo-slider-custom.js"></script>
    <script src="js/owl-custom.js"></script>
    <script src="js/main.js"></script>

</body>

<!-- Mirrored from freebw.com/templates/ecofood/index1.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 29 Aug 2024 05:33:19 GMT -->

</html>