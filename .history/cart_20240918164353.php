<?php
// Start the session
session_start();

// Include database connection file
include 'conn.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if the cart session exists and is not empty
$cart_empty = !isset($_SESSION['cart']) || empty($_SESSION['cart']);

// Handle removal of an item from the cart
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);

        if (empty($_SESSION['cart'])) {
            unset($_SESSION['cart']);
            $cart_empty = true;
        }
    }

    header('Location: cart.php');
    exit();
}

// Handle updating the quantity
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $id => $quantity) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] = max(1, intval($quantity));
        }
    }
    header('Location: cart.php');
    exit();
}

// Check if the logged-in user's account has been deleted
if (isset($_SESSION['user_id'])) {
    $user_id = intval($_SESSION['user_id']);
    $sql = "SELECT id FROM user WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) {
        session_destroy();
        header("Location: login.php");
        exit();
    }
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <!-- Include CSS files -->
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
        /* Custom styles for table */
        .table img {
            width: 100px;
        }

        .table td {
            vertical-align: middle;
        }

        .table td img {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .table td.quantity-col {
            width: 10%;
        }

        .table td.action-col {
            width: 20%;
        }

        @media (max-width: 768px) {
            .table td {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <?php include 'navbar.php'; ?>

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
                    <table class="table table-bordered table-responsive">
                        <thead class="thead-dark">
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th class="quantity-col">Quantity</th>
                                <th>Total</th>
                                <th class="action-col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                                <tr>
                                    <td class="text-center">
                                        <img src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                                    </td>
                                    <td><?php echo htmlspecialchars($item['title']); ?></td>
                                    <td>₹<?php echo htmlspecialchars($item['price']); ?></td>
                                    <td class="quantity-col">
                                        <input type="number" name="quantity[<?php echo $id; ?>]" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1" class="form-control form-control-sm">
                                    </td>
                                    <td>₹<?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                                    <td class="action-col">
                                        <a href="?action=remove&id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Remove</a>
                                        <button type="submit" name="update_cart" class="btn btn-warning btn-sm mt-2">Update Quantity</button>
                                    </td>
                                    <?php $total += $item['price'] * $item['quantity']; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" style="font-weight: bold" class="text-right">Total</td>
                                <td colspan="2" style="font-weight: bold">₹<?php echo $total; ?></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="text-center mt-4">
                        <a href="checkout.php" class="btn btn-success btn-lg">
                            Proceed to Checkout
                        </a>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <!-- Include JavaScript files -->
    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>
<?php
// Start the session
session_start();

// Include database connection file
include 'conn.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if the cart session exists and is not empty
$cart_empty = !isset($_SESSION['cart']) || empty($_SESSION['cart']);

// Handle removal of an item from the cart
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);

        if (empty($_SESSION['cart'])) {
            unset($_SESSION['cart']);
            $cart_empty = true;
        }
    }

    header('Location: cart.php');
    exit();
}

// Handle updating the quantity
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $id => $quantity) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] = max(1, intval($quantity));
        }
    }
    header('Location: cart.php');
    exit();
}

// Check if the logged-in user's account has been deleted
if (isset($_SESSION['user_id'])) {
    $user_id = intval($_SESSION['user_id']);
    $sql = "SELECT id FROM user WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) {
        session_destroy();
        header("Location: login.php");
        exit();
    }
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <!-- Include CSS files -->
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
        /* Custom styles for table */
        .table img {
            width: 100px;
        }

        .table td {
            vertical-align: middle;
        }

        .table td img {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .table td.quantity-col {
            width: 10%;
        }

        .table td.action-col {
            width: 20%;
        }

        @media (max-width: 768px) {
            .table td {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/includes/header.php'; ?>
    <?php include __DIR__ . '/includes/navbar.php'; ?>

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
                            <a href="shop-list-without-sidebar.php">Your Cart</a>
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
                    <table class="table table-bordered table-responsive">
                        <thead class="thead-dark">
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th class="quantity-col">Quantity</th>
                                <th>Total</th>
                                <th class="action-col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                                <tr>
                                    <td class="text-center">
                                        <img src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                                    </td>
                                    <td><?php echo htmlspecialchars($item['title']); ?></td>
                                    <td>₹<?php echo htmlspecialchars($item['price']); ?></td>
                                    <td class="quantity-col">
                                        <input type="number" name="quantity[<?php echo $id; ?>]" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1" class="form-control form-control-sm">
                                    </td>
                                    <td>₹<?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                                    <td class="action-col">
                                        <a href="?action=remove&id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Remove</a>
                                        <button type="submit" name="update_cart" class="btn btn-warning btn-sm mt-2">Update Quantity</button>
                                    </td>
                                    <?php $total += $item['price'] * $item['quantity']; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" style="font-weight: bold" class="text-right">Total</td>
                                <td colspan="2" style="font-weight: bold">₹<?php echo $total; ?></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="text-center mt-4">
                        <a href="checkout.php" class="btn btn-success btn-lg">
                            Proceed to Checkout
                        </a>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </section>

    <?php include 'F.'; ?>

    <!-- Include JavaScript files -->
    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>
