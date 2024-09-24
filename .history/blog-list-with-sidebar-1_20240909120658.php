<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blog list with sidebar 1 - Ecofood html5 templates</title>
    <meta name="description" content="Ecofood theme template">
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
    <style>
        /* Style for the popup */
        .popup {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .popup-content {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            position: relative;
        }
        .popup img {
            max-width: 100%;
            height: auto;
        }
        .popup-close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
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
                <a href="index.php">
                    <img src="images/home_1.jpg" alt />
                </a>
                <img class="popup-demo-homepage" src="images/home_1.jpg" alt="Image" />
            </li>
            <li>
                <!-- Additional layout options can be added here -->
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
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="blog-list-with-sidebar-1.php">Our blog</a>
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
                            <img src="images/blog-item-04.jpg" alt="Make: A healthy and delicious St. Patrick’s day smoothie" />
                        </a>
                    </div>
                    <div class="blog-item-title">
                        <h3 class="title">
                            <a href="#">Make: A healthy and delicious St. Patrick’s day smoothie</a>
                        </h3>
                    </div>
                    <p class="blog-item-date">
                        <i class="fa fa-clock-o"></i>
                        <span>on April 28, 2023</span>
                    </p>
                    <p class="blog-item-desc">
                        Give your body a green smoothie to drink. Delicious green smoothie you’ll want to drink every day!...
                    </p>
                    <a class="btn btn-primary" href="#">Read more</a>
                </div>
                <!-- Add more blog items here -->
            </div>
        </div>
    </div>
</div>

<!-- Popup HTML -->
<div id="popup" class="popup">
    <div class="popup-content">
        <span class="popup-close">&times;</span>
        <img id="popup-img" src="" alt="Popup Image">
        <p id="popup-caption"></p>
    </div>
</div>

<script>
    // Function to open the popup
    function openPopup(src, caption) {
        var popup = document.getElementById('popup');
        var popupImg = document.getElementById('popup-img');
        var popupCaption = document.getElementById('popup-caption');
        popup.style.display = 'flex';
        popupImg.src = src;
        popupCaption.textContent = caption;
    }

    // Function to close the popup
    function closePopup() {
        var popup = document.getElementById('popup');
        popup.style.display = 'none';
    }

    // Add event listener to close the popup when clicking the close button
    document.querySelector('.popup-close').addEventListener('click', closePopup);

    // Add event listener to close the popup when clicking outside the popup content
    document.getElementById('popup').addEventListener('click', function(e) {
        if (e.target === this) {
            closePopup();
        }
    });

    // Add event listeners to blog item images
    document.querySelectorAll('.blog-item-image a').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent the default link behavior
            var img = this.querySelector('img');
            openPopup(img.src, img.alt);
        });
    });
</script>
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vendor/css-hamburgers/dist/hamburgers.min.js"></script>
<script src="vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="vendor/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
