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

// Check if the cart session exists and is not empty
$cart_empty = !isset($_SESSION['cart']) || empty($_SESSION['cart']);

// Handle removal of an item from the cart
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Remove the item from the cart if it exists
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);

        // If the cart is empty after removal, destroy the cart session
        if (empty($_SESSION['cart'])) {
            unset($_SESSION['cart']);
            $cart_empty = true;
        }
    }

    // Redirect to the same page to avoid resubmission issues
    header('Location: cart.php');
    exit();
}

// Handle updating the quantity
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $id => $quantity) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] = max(1, intval($quantity)); // Ensure quantity is at least 1
        }
    }
    // Redirect to avoid resubmission issues
    header('Location: cart.php');
    exit();
}

$total = 0;
 
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include your database connection file if needed
include 'conn.php';

// Check if the cart session exists and is not empty
$cart_empty = !isset($_SESSION['cart']) || empty($_SESSION['cart']);

// Handle removal of an item from the cart
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Remove the item from the cart if it exists
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);

        // If the cart is empty after removal, destroy the cart session
        if (empty($_SESSION['cart'])) {
            unset($_SESSION['cart']);
            $cart_empty = true;
        }
    }

    // Redirect to the same page to avoid resubmission issues
    header('Location: cart.php');
    exit();
}

// Handle updating the quantity
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $id => $quantity) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] = max(1, intval($quantity)); // Ensure quantity is at least 1
        }
    }
    // Redirect to avoid resubmission issues
    header('Location: cart.php');
    exit();
}

$total = 0;
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/main.css" rel="stylesheet">
    <style>
        /* Set equal width for image and product columns */
        .col-image, .col-product {
            width: 150px; /* Adjust this width as needed */
        }

        /* Make quantity and action columns the same width as price */
        .col-price, .col-quantity, .col-action {
            width: 120px; /* Adjust this width as needed */
        }

        /* Adjust button spacing in the action column */
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 5px; /* Space between buttons */
        }

        /* Center images within their table cells */
        .img-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%; /* Ensures the image container takes full height */
        }

        /* Increase image size */
        img {
            max-width: 80px; /* Adjust size as needed */
            height: auto;
        }

        /* Make quantity input smaller */
        .quantity-input {
            width: 70px;
        }

        /* Make <tfoot> td bold */
        tfoot td {
            font-weight: bold;
        }

        /* For small screens, make the table scrollable */
        @media (max-width: 768px) {
            .table-responsive {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .col-image, .col-product, .col-price, .col-quantity, .col-action {
                width: auto; /* Allow columns to adjust width on small screens */
            }

            .quantity-input {
                width: 100%; /* Make quantity input take full width on small screens */
            }
        }
    </style>
</head>
<body>

<header>
    <?php include 'Unavbar.php'; ?>
</header>

<section>
    <div class="section primary-color-background">
        <div class="container">
            <div class="p-t-70 p-b-85">
                <div class="heading-page-1">
                    <h3>Your Cart</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="section border-bottom-grey">
        <div class="container">
            <div class="breadcrumb-1">
                <ul>
                    <li>
                        <a href="shop-list-with-sidebar.php">Your Cart</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container mt-5">
        <?php if ($cart_empty): ?>
            <div class="alert alert-warning text-center" role="alert">
                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                <strong>No record found!</strong> Your cart is empty.
            </div>
            <div class="text-center mt-4">
                <a href="shop-list-without-sidebar.php" class="btn btn-primary btn-sm">
                    <i class="fa fa-shopping-cart"></i> Continue Shopping
                </a>
            </div>
        <?php else: ?>
            <form method="post" action="">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th class="col-image">Image</th>
                                <th class="col-product">Product</th>
                                <th class="col-price">Price</th>
                                <th class="col-quantity">Quantity</th>
                                <th class="col-price">Total</th>
                                <th class="col-action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                                <tr>
                                    <td class="col-image">
                                        <div class="img-container">
                                            <img src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                                        </div>
                                    </td>
                                    <td class="col-product"><?php echo htmlspecialchars($item['title']); ?></td>
                                    <td class="col-price">₹<?php echo htmlspecialchars($item['price']); ?></td>
                                    <td class="col-quantity">
                                        <input type="number" name="quantity[<?php echo $id; ?>]" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1" class="form-control form-control-sm quantity-input">
                                    </td>
                                    <td class="col-price">₹<?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                                    <td class="col-action">
                                        <div class="action-buttons">
                                            <button type="submit" name="update_cart" class="btn btn-primary btn-sm">
                                                <i class="fa fa-refresh"></i> Update
                                            </button>
                                            <a href="?action=remove&id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Remove</a>
                                        </div>
                                    </td>
                                    <?php $total += $item['price'] * $item['quantity']; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right">Total</td>
                                <td colspan="2">₹<?php echo $total; ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="text-center mt-4">
                    <a href="checkout.php" class="btn btn-success btn-lg">
                        Proceed to Checkout
                    </a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</section>

<footer>
    <?php include 'Footer.php'; ?>
</footer>

<!-- Bootstrap and jQuery JS -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/main.css" rel="stylesheet">
</head>
<body>

<header>
    <?php include 'Unavbar.php'; ?>
</header>

<section>
<div class="section primary-color-background">
<div class="container">
<div class="p-t-70 p-b-85">

<div class="heading-page-1">
<h3>Your Cart</h3>
</div>
</div>
</div>
</div>
<div class="section border-bottom-grey">
<div class="container">
<div class="breadcrumb-1">
<ul>
 
<li>
<a href="shop-list-with-sidebar.php">Your Cart</a>
</li>
 
</ul>
</div>
</div>
</div>
</section>

<section>
    <div class="container mt-5">

        <?php if ($cart_empty): ?>
            <div class="alert alert-warning text-center" role="alert">
                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                <strong>No record found!</strong> Your cart is empty.
            </div>
            <div class="text-center mt-4">
                <a href="shop-list-without-sidebar.php" class="btn btn-primary btn-sm">
                    <i class="fa fa-shopping-cart"></i> Continue Shopping
                </a>
            </div>
        <?php else: ?>
            <form method="post" action="">
                <table class="table table-bordered">
                    <thead class="thead-dark">
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
                                <td>
                                    <input type="number" name="quantity[<?php echo $id; ?>]" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1" class="form-control form-control-sm">
                                </td>
                                <td>$<?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                                <td>
                                    <a href="?action=remove&id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Remove</a>
                                </td>
                                <?php $total += $item['price'] * $item['quantity']; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right font-weight-bold">Total</td>
                            <td colspan="2" class="font-weight-bold">$<?php echo $total; ?></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="text-center mt-4">
                    <button type="submit" name="update_cart" class="btn btn-primary btn-sm">
                        <i class="fa fa-refresh"></i> Update Cart
                    </button>
                    <a href="checkout.php" class="btn btn-success btn-lg">
                        Proceed to Checkout
                    </a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</section>

<footer>
    <?php include 'Footer.php'; ?>
</footer>

<!-- Bootstrap and jQuery JS -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
