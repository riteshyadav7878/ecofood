<?php
session_start();

include 'conn.php';
// If the user is already logged in, redirect them to the protected page
if (isset($_SESSION['username'])) {
    header("Location: shop-list-without-sidebar.php");
    exit();
}

?>

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
            <!-- Add more layout options here -->
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
                        <span>on April 28, 2017</span>
                    </p>
                    <p class="blog-item-content">Proin aliquet gravida nibh, in fringilla est eleifend et. Pellentesque hendrerit augue ut eros iaculis elementum. Donec porta efficitur lorem ut ultricies. Donec vulputate leo a enim dapibus sollicitudin. In sed mollis sapien, in congue nulla. Mauris lorem nulla, tincidunt suscipit purus eu, dapibus semper lacus.</p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="blog-item-1">
                            <div class="blog-item-image">
                                <a href="#">
                                    <img src="images/blog-item-05.jpg" alt="Make: How to plant an organic garden" />
                                </a>
                            </div>
                            <div class="blog-item-title">
                                <h3 class="title">
                                    <a href="#">Make: How to plant an organic garden</a>
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
                                    <img src="images/blog-item-06.jpg" alt="Top 10 ingredients found everywhere across food industry" />
                                </a>
                            </div>
                            <div class="blog-item-title">
                                <h3 class="title">
                                    <a href="#">Top 10 ingredients found everywhere across food industry</a>
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
                                    <img src="images/blog-item-07.jpg" alt="Change: Recycle K-Cups in the garden!" />
                                </a>
                            </div>
                            <div class="blog-item-title">
                                <h3 class="title">
                                    <a href="#">Change: Recycle K-Cups in the garden!</a>
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
                                    <img src="images/blog-item-08.jpg" alt="News: We’re on YouTube!" />
                                </a>
                            </div>
                            <div class="blog-item-title">
                                <h3 class="title">
                                    <a href="#">News: We’re on YouTube!</a>
                                </h3>
                            </div>
                            <p class="blog-item-date">
                                <i class="fa fa-clock-o"></i>
                                <span>on April 24, 2017</span>
                            </p>
                        </div>
                    </div>
                </div>
              
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
</body>
</html>
