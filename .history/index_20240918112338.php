<?php
session_name("user_session");
session_start();

include 'conn.php';
// If the user is already logged in, redirect them to the protected page
if (isset($_SESSION['username'])) {
    header("Location: shop-list-without-sidebar.php");
    exit();
}



// Fetch all active sliders
$sql = "SELECT * FROM slider WHERE status='active'";
$result = $conn->query($sql);
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
    <title>Home</title>
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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .carousel-item img {
            width: 100%;
            height: 500px;
            /* Fixed height for images */
            object-fit: cover;
            /* Ensure images cover the area without distortion */
            border: 5px solid #fff;
            /* White border around images */
            border-radius: 10px;
            /* Optional: rounded corners for the border */
        }

        .carousel-caption {
            text-align: center;
            /* Center align text */
            background-color: rgba(0, 0, 0, 0.5);
            /* Semi-transparent background for readability */
            padding: 15px;
            /* Add padding */
            border-radius: 5px;
            /* Rounded corners for caption box */
        }

        .carousel-caption h5 {
            font-weight: bold;
            /* Make title bold */
            font-size: 3rem;
            /* Increase font size of title */
        }

        .carousel-caption p {
            font-size: 2rem;
            /* Increase font size of description */
        }

        .carousel-control-prev,
        .carousel-control-next {
            color: #6c757d;
            /* Secondary color for the controls (gray) */
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: #6c757d;
            /* Secondary color for the control icons background */
        }
        .product-1 {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #fff;
            display: flex;
            flex-direction: column;
            height: 100%;
        }


        .product-image .image-holder {
            width: 100%;
            height: 200px;
            overflow: hidden;
            display: block;
            position: relative;
        }

        .product-image .image-holder img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
        }


        .product-status {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 5px 10px;
            color: #fff;
            font-size: 0.8em;
            text-transform: uppercase;
            border-radius: 3px;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .product-status.hot {
            background-color: red;
        }

        .product-status.sale {
            background-color: orange;
        }

        .product-status.new {
            background-color: green;
        }
    </style>
</head>

<body>

    <div class="page-loader">
        <div class="loader"></div>
    </div>
    
    <header>

        <!--    Navbar -->
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
        <div id="carouselExampleIndicators" class="carousel slide">
            <ol class="carousel-indicators">
                <?php $i = 0;
                while ($row = $result->fetch_assoc()): ?>
                    <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i; ?>" class="<?php echo $i == 0 ? 'active' : ''; ?>"></li>
                <?php $i++;
                endwhile; ?>
            </ol>
            <div class="carousel-inner">
                <?php
                $result->data_seek(0); // Reset result pointer to the start
                $i = 0;
                while ($row = $result->fetch_assoc()):
                ?>
                    <div class="carousel-item <?php echo $i == 0 ? 'active' : ''; ?>">
                        <img src="<?php echo $row['image_url']; ?>" class="d-block w-100" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p><?php echo htmlspecialchars($row['description']); ?></p>
                        </div>
                    </div>
                <?php $i++;
                endwhile; ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </section>
    <section>
    <div class="page-content p-t-40 p-b-100">
    <div class="container">

                <div class="heading-section-1">
                    <h3>WELCOME TO OUR FARM</h3>
                </div>
                <div class="m-t-50">

                    <div class="about-1">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="about-image">
                                    <img src="images/about-01.jpg" alt="about farm" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="about-content">
                                    <div class="about-content-item">
                                        <div class="content-image">
                                            <img src="images/icons/ic-about-01.png" alt="about icon" />
                                        </div>
                                        <div class="content-main">
                                            <h3 class="title-content">Certified organic standards</h3>
                                            <p class="content-content">Phasellus vel ante blandit, suscipit neque sed, egestas quam. Maecenas mi sem, tristique in cursus non, pharetra id enim.</p>
                                        </div>
                                    </div>
                                    <div class="about-content-item">
                                        <div class="content-image">
                                            <img src="images/icons/ic-about-02.png" alt="about icon" />
                                        </div>
                                        <div class="content-main">
                                            <h3 class="title-content">Eco systems & biodiversity</h3>
                                            <p class="content-content">Curabitur scelerisque diam at diam ullamcorper tincidunt. Donec pellentesque lectus vitae efficitur luctus phasellus.</p>
                                        </div>
                                    </div>
                                    <div class="about-content-item">
                                        <div class="content-image">
                                            <img src="images/icons/ic-about-03.png" alt="about icon" />
                                        </div>
                                        <div class="content-main">
                                            <h3 class="title-content">Fair prices for you</h3>
                                            <p class="content-content">Aenean at est euismod, finibus erat sit amet, rutrum orci. Maecenas vel dapibus odio. Duis est lorem, tristique ornare in lobor.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="m-t-100 m-b-60">
        <div class="section white-background">
            <div class="container">

                <div class="heading-section-1">
                    <h3>OUR PRODUCTS</h3>
                </div>

                <div class="row">
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="col-md-3 col-sm-6 mt-5">
                        <div class="product-1">
                            <div class="product-image">
                                <a href="product-details-02.php?id=<?php echo $row['id']; ?>" class="image-holder">
                                    <img src="images/<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" />
                                    <?php if (!empty($row['status'])): ?>
                                        <div class="product-status <?php echo $row['status']; ?>">
                                            <span><?php echo strtoupper($row['status']); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </a>
                            </div>
                            <div class="product-content">
                                <h3 class="title">
                                    <a class="name" href="product-details-1.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['title']); ?></a>
                                </h3>
                                <p class="price">₹<?php echo htmlspecialchars($row['price']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            </div>
        </div>
    </section>

    <section>
        <div class="section cover-background parallax-background" style="background: url(images/carousel-09.jpg) center center no-repeat;">
            <div class="container">

                <div class="call-to-action-1">
                    <div class="row">
                        <div class="col-md-8 col-md-push-2">
                            <div class="cta-heading">
                                <h3>CELEBRATE SPRING AT OUR FARM!</h3>
                            </div>
                            <div class="cta-content">
                                <p>If you plan to attend during the week (Tuesday-Friday) we highly recommend you purchase your ticket online in ADVANCE. If we do not sell out during the week, you will be able to purchase tickets at the door.</p>
                            </div>
                            <a class="cta-btn au-btn au-btn-primary au-btn-radius" href="#">Buy tickets</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section>
        <div class="section white-background p-t-100 p-b-80">
            <div class="container">

                <div class="heading-section-1">
                    <h3>FROM OUR BLOG</h3>
                </div>
                <div class="last-blog-list m-t-50">
                    <div class="row">
                        <div class="col-md-4">

                            <div class="blog-item-1">
                                <div class="blog-item-image">
                                    <a href="#">
                                        <img src="images/blog-item-01.jpg" alt="Change: Recycle K-Cups in the garden!
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
                                    <span>on April 28, 2017</span>
                                </p>
                            </div>

                        </div>
                        <div class="col-md-4">

                            <div class="blog-item-1">
                                <div class="blog-item-image">
                                    <a href="#">
                                        <img src="images/blog-item-02.jpg" alt="News: We’re on YouTube!
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
                                    <span>on April 28, 2017</span>
                                </p>
                            </div>

                        </div>
                        <div class="col-md-4">

                            <div class="blog-item-1">
                                <div class="blog-item-image">
                                    <a href="#">
                                        <img src="images/blog-item-03.jpg" alt="Make: A healthy and delicious St. Patrick’s day smoothie
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
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="section grey-background p-t-50 p-b-50">
        <div class="container">
            <div class="partner-list owl-carousel" data-carousel-items="5" data-carousel-autoplay="true" data-carousel-center="false" data-carousel-loop="true" data-carousel-nav="false" data-carousel-xs="2" data-carousel-sm="3" data-carousel-md="5" data-carousel-lg="5" data-carousel-margin="80">

                <div class="partner-1">
                    <div class="partner-icon">
                        <a href="#">
                            <img src="images/icons/ic-partner-01.png" alt="partner" />
                        </a>
                    </div>
                </div>


                <div class="partner-1">
                    <div class="partner-icon">
                        <a href="#">
                            <img src="images/icons/ic-partner-02.png" alt="partner" />
                        </a>
                    </div>
                </div>


                <div class="partner-1">
                    <div class="partner-icon">
                        <a href="#">
                            <img src="images/icons/ic-partner-03.png" alt="partner" />
                        </a>
                    </div>
                </div>


                <div class="partner-1">
                    <div class="partner-icon">
                        <a href="#">
                            <img src="images/icons/ic-partner-04.png" alt="partner" />
                        </a>
                    </div>
                </div>


                <div class="partner-1">
                    <div class="partner-icon">
                        <a href="#">
                            <img src="images/icons/ic-partner-05.png" alt="partner" />
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer -->

    <?php include 'Footer.php'; ?>

    <div class="modal fade quick-view-1" id="myModal" role="dialog">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <button class="fa fa-close" type="button" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">

                            <div class="product-detail-image-1">
                                <div class="product-primary-image owl-carousel" data-carousel-items="1" data-carousel-dotsData="true" data-carousel-nav="true" data-carousel-dots="true" data-carousel-xs="1" data-carousel-sm="1" data-carousel-md="1" data-carousel-lg="1" data-carousel-animateout="fadeOut" data-carousel-animatein="fadeIn">
                                    <img data-dot="&lt;img src='images/product-details-image-05.jpg'&gt;" src="images/product-details-image-02.jpg" alt="product detail image" />
                                    <img data-dot="&lt;img src='images/product-details-image-06.jpg'&gt;" src="images/product-details-image-03.jpg" alt="product detail image" />
                                    <img data-dot="&lt;img src='images/product-details-image-07.jpg'&gt;" src="images/product-details-image-04.jpg" alt="product detail image" />
                                    <img data-dot="&lt;img src='images/product-details-image-08.jpg'&gt;" src="images/product-details-image-01.jpg" alt="product detail image" />
                                </div>
                            </div>

                        </div>
                        <div class="col-md-7">

                            <div class="product-detail-content-1">
                                <div class="product-name">
                                    <h3>Organic strawberries</h3>
                                </div>
                                <div class="product-cert">
                                    <a href="#">
                                        <img src="images/icons/ic-product-cert-01.png" alt="product cert" />
                                    </a>
                                    <a href="#">
                                        <img src="images/icons/ic-product-cert-02.png" alt="product cert" />
                                    </a>
                                    <a href="#">
                                        <img src="images/icons/ic-product-cert-03.png" alt="product cert" />
                                    </a>
                                </div>
                                <div class="product-price">
                                    <p>$5.99 /ea</p>
                                </div>
                                <div class="product-introduce">
                                    <p>Morbi molestie nisi purus, vitae vestibulum turpis lacinia sit amet. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia.</p>
                                    <p>In Stock</p>
                                    <p>SKU: 1952C14</p>
                                </div>
                                <div class="prodcut-add-to-cart">
                                    <input class="input-size" type="text" value="1" />
                                    <button class="au-btn au-btn-primary au-btn-radius btn-add-to-cart" type="submit">ADD TO CART</button>
                                    <a class="au-btn au-btn-border au-btn-radius btn-add-to-wishlist" href="#">ADD TO WISHLIST</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="up-to-top">
        <i class="fa fa-angle-up"></i>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 

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