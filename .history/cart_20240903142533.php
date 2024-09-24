<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include your database connection file if needed
include 'conn.php';

// Check if the cart session exists
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty!";
    exit();
}

// Handle removal of an item from the cart
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Remove the item from the cart if it exists
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);

        // If the cart is empty after removal, destroy the cart session
        if (empty($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }
    }

    // Redirect to the same page to avoid resubmission issues
    header('Location: cart.php');
    exit();
}

$total = 0;
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
<meta charset="UTF-8">
<title>Shopping Cart - Ecofood HTML5 Templates</title>
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
            <li><a href="index.php"><img src="images/home_1.jpg" alt /></a><img class="popup-demo-homepage" src="images/home_1.jpg" alt="Image" /></li>
            <li><a href="index.php"><img src="images/home_2.jpg" alt /></a><img class="popup-demo-homepage" src="images/home_2.jpg" alt="Image" /></li>
            <li><a href="index.php"><img src="images/home_3.jpg" alt /></a><img class="popup-demo-homepage" src="images/home_3.jpg" alt="Image" /></li>
            <li><a href="index3.php"><img src="images/home_4.jpg" alt /></a><img class="popup-demo-homepage" src="images/home_4.jpg" alt="Image" /></li>
        </ul>
    </div>
</div>

<header>
    <div class="section dark-background">
        <div class="container">
            <div class="header-2">
                <div class="header-left">
                    <p><i class="fa fa-map-marker"></i>256 Address Name, New York city <span>|</span> <i class="fa fa-clock-o"></i>07:30 Am - 11:00 Pm</p>
                </div>
                <div class="header-right">
                    <div class="header-login">
                        <a href="login.php"><i class="fa fa-user"></i>Log in</a>
                        <span>/</span>
                        <a href="register.php">Register</a>
                    </div>
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

<header>
    <?php include 'Navbar.php'; ?>
</header>

<section>
    <div class="section primary-color-background">
        <div class="container">
            <div class="p-t-70 p-b-85">
                <div class="heading-page-1">
                    <h3>Shopping Cart</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="section border-bottom-grey">
        <div class="container">
            <div class="breadcrumb-1">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="cart.php">Shopping Cart</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="cart-section">
    <div class="container">
        <h1>Your Cart</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                    <tr>
                        <td><img src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" width="50"></td>
                        <td><?php echo htmlspecialchars($item['title']); ?></td>
                        <td>$<?php echo htmlspecialchars($item['price']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td>$<?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                        <td><a href="?action=remove&id=<?php echo $id; ?>" class="btn btn-danger">Remove</a></td>
                        <?php $total += $item['price'] * $item['quantity']; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right">Total</td>
                    <td colspan="2">$<?php echo $total; ?></td>
                </tr>
            </tfoot>
        </table>
        <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
    </div>
</section>

<footer>
    <?php include 'Footer.php'; ?>
</footer>

<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
