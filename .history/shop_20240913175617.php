<?php
session_start();

include 'conn.php';
// If the user is already logged in, redirect them to the protected page
if (isset($_SESSION['username'])) {
    header("Location: shop-list-without-sidebar.php");
    exit();
}

// Fetch all products from the database in descending order
$sql = "SELECT * FROM product ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

// Check for query execution errors
if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="UTF-8">
    <title>Shop</title>
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

    <style>
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
    <header>
        <div class="section dark-background">
            <div class="container">
                <div class="header-2">
                    <div class="header-left">
                        <p>
                            <i class="fa fa-map-marker"></i>256 Address Name, New York City
                            <span>|</span>
                            <i class="fa fa-clock-o"></i>07:30 Am - 11:00 Pm
                        </p>
                    </div>
                    <div class="header-right">
                        <div class="header-login">
                            <a href="login.php"><i class="fa fa-user"></i>Log in</a>
                            <span>/</span>
                            <a href="register.php">Register</a>
                        </div>
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
                        <h3>Shop Categories</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="section border-bottom-grey">
            <div class="container">
                <div class="breadcrumb-1">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="shop-list-with-sidebar.php">Shop</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="page-content p-t-40 p-b-100">
        <div class="container">
            <div class="m-b-35">
                <div class="sort-widget-1">
                    <div class="text-result">
                        <p>Showing 1–12 of 28 results</p>
                    </div>
                    <div class="select-sort">
                        <select>
                            <option value="something">Sort by default</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="col-md-3 col-sm-6">
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

</html>
