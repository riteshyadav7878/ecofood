<?php
session_name("user_session");
session_start();

include 'conn.php';
// If the user is already logged in, redirect them to the protected page
if (isset($_SESSION['username'])) {
    header("Location: shop-list-without-sidebar.php");
    exit();
}

?>
<!DOCTYPE html>

<!-- [if gt IE 8] <!-->
<html class="no-js" lang="en">
<!-- <![endif]-->

<!-- Mirrored from freebw.com/templates/ecofood/about-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 29 Aug 2024 05:33:28 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>

    <meta charset="UTF-8">
    <title>About</title>
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

    <section>
        <div class="section primary-color-background">
            <div class="container">
                <div class="p-t-70 p-b-85">

                    <div class="heading-page-1">
                        <h3>About Us</h3>
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
                            <a href="about-1.php">About Us</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="page-content p-t-40 p-b-90">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-push-2">

                    <div class="about-3">
                        <div class="about-image">
                            <img src="images/about-02.jpg" alt="about image" />
                        </div>
                        <div class="about-title">
                            <h3 class="title">
                                <a href="blog-details-with-sidebar-1.html">Certified organic products - Fresh from our farm!</a>
                            </h3>
                        </div>
                        <div class="about-content">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent maximus placerat commodo. Ut sapien felis, porta vel luctus vitae, mollis id quam. Phasellus elementum semper felis id convallis. Sed mattis mi ut sem rhoncus
                                posuere. Cras viverra aliquet lectus et dapibus. Nullam maximus neque est, at dignissim ante condimentum venenatis. In risus nunc, hendrerit a ante quis, venenatis ornare elit. Nullam bibendum porta finibus. Curabitur pretium
                                vel dui id commodo. Vestibulum quis tempor felis, ac maximus augue pellentesque sagittis quam at sem ultrices tincidunt.
                            </p>
                        </div>
                    </div>


                    <div class="about-3">
                        <div class="about-image">
                            <img src="images/about-03.jpg" alt="about image" />
                        </div>
                        <div class="about-title">
                            <h3 class="title">
                                <a href="blog-details-with-sidebar-1.html">Take a look at our beautiful farm</a>
                            </h3>
                        </div>
                        <div class="about-content">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent maximus placerat commodo. Ut sapien felis, porta vel luctus vitae, mollis id quam. Phasellus elementum semper felis id convallis. Sed mattis mi ut
                            </p>
                        </div>
                    </div>


                    <div class="about-3">
                        <div class="about-image">
                            <img src="images/about-04.jpg" alt="about image" />
                        </div>
                        <div class="about-title">
                            <h3 class="title">
                                <a href="blog-details-with-sidebar-1.html">Taste and quality you can trust, price you’ll love!</a>
                            </h3>
                        </div>
                        <div class="about-content">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent maximus placerat commodo. Ut sapien felis, porta vel luctus vitae, mollis id quam. Phasellus elementum semper felis id convallis. Sed mattis mi ut sem rhoncus
                                posuere. Cras viverra aliquet lectus et dapibus. Nullam maximus neque est, at dignissim ante condimentum venenatis. In risus nunc, hendrerit a ante quis, venenatis ornare elit. Nullam bibendum porta
                            </p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent maximus placerat commodo. Ut sapien felis, porta vel luctus vitae, mollis id quam. Phasellus elementum semper felis id convallis. Sed mattis mi ut
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include 'Footer.php'; ?>

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

<!-- Mirrored from freebw.com/templates/ecofood/about-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 29 Aug 2024 05:33:28 GMT -->

</html>