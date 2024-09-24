<?php
session_name("user_session");
session_start();

include 'conn.php';

// Redirect logged-in users
if (isset($_SESSION['username'])) {
    header("Location: shop-list-without-sidebar.php");
    exit();
}

// Fetch all active sliders
$sql_sliders = "SELECT * FROM slider WHERE status='active'";
$result_sliders = $conn->query($sql_sliders);

// Fetch all products
$sql_products = "SELECT * FROM product ORDER BY id DESC";
$result_products = mysqli_query($conn, $sql_products);

// Check for query execution errors
if (!$result_products) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <meta name="description" content="Ecofood theme template">
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
            object-fit: cover;
            border: 5px solid #fff;
            border-radius: 10px;
        }

        .carousel-caption {
            text-align: center;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 15px;
            border-radius: 5px;
        }

        .carousel-caption h5 {
            font-weight: bold;
            font-size: 3rem;
        }

        .carousel-caption p {
            font-size: 2rem;
        }

        .carousel-control-prev,
        .carousel-control-next {
            color: #6c757d;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: #6c757d;
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

    <!-- Carousel Section -->
    <section>
        <div id="carouselExampleIndicators" class="carousel slide">
            <ol class="carousel-indicators">
                <?php $i = 0;
                while ($row = $result_sliders->fetch_assoc()): ?>
                    <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i; ?>" class="<?php echo $i == 0 ? 'active' : ''; ?>"></li>
                <?php $i++;
                endwhile; ?>
            </ol>
            <div class="carousel-inner">
                <?php
                $result_sliders->data_seek(0); // Reset result pointer to the start
                $i = 0;
                while ($row = $result_sliders->fetch_assoc()):
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

    <!-- Main Content Section -->
    <div class="container">
        <div class="row">
            <!-- Celebrate Spring at Our Farm Section -->
            <div class="col-12">
                <div class="section-title text-center">
                    <h2>CELEBRATE SPRING AT OUR FARM!</h2>
                    <p>Discover our range of fresh and organic produce.</p>
                </div>
            </div>
        </div>

        <!-- Product Display Section -->
        <div class="row">
            <?php while ($product = mysqli_fetch_assoc($result_products)): ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product-1">
                        <div class="product-image">
                            <div class="image-holder">
                                <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                <?php if ($product['status']): ?>
                                    <div class="product-status <?php echo htmlspecialchars($product['status']); ?>">
                                        <?php echo htmlspecialchars(ucfirst($product['status'])); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="product-details">
                            <h5 class="product-title">
                                <a href="#"><?php echo htmlspecialchars($product['name']); ?></a>
                            </h5>
                            <p class="product-price">
                                ₹<?php echo number_format($product['price'], 2); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="vendor/revolution/js/jquery.themepunch.revolution.min.js"></script>
    <script src="vendor/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script src="js/theme.js"></script>
</body>
</html>
