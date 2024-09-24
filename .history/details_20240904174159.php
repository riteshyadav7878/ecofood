<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Ecofood</title>
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
        .centered-container {
            min-height: 100vh; /* Full height of the viewport */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa; /* Light background color */
        }
    </style>
</head>
<body>

<div class="page-loader">
    <div class="loader"></div>
</div>

<header>
    <div class="section dark-background">
        <div class="container">
            <div class="header-2">
                <div class="header-left">
                    <p>
                        <i class="fa fa-map-marker"></i>256 Address Name, New York city
                        <span>|</span>
                        <i class="fa fa-clock-o"></i>07:30 AM - 11:00 PM
                    </p>
                </div>
                <div class="header-right">
                    <a href="logout.php">
                        <i class="fa fa-user"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php include 'Navbar.php'; ?>
</header>

<section>
    <div class="section primary-color-background">
        <div class="container">
            <div class="p-t-70 p-b-85">
                <div class="heading-page-1">
                    <h3>Welcome to Ecofood!</h3>
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
                </ul>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <h1>Discover Our Products</h1>
    <p>Explore the best of Ecofood products and offers!</p>
    <a href="shop.php" class="btn btn-primary">Shop Now</a>
</div>

<?php include 'Footer.php'; ?>

<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vendor/retinajs/dist/retina.min.js"></script>
<script src="vendor/SmoothScroll/SmoothScroll.js"></script>
<script src="js/switcher-custom.js"></script>
<script src="js/main.js"></script>

</body>
</html>
