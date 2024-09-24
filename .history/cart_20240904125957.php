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

$total = 0;
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart - Ecofood HTML5 Templates</title>
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
    <?php include 'Navbar.php'; ?>
</header>

<section>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Your Cart</h1>

        <?php if ($cart_empty): ?>
            <div class="alert alert-warning text-center" role="alert">
                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                <strong>No record found!</strong> Your cart is empty.
            </div>
            <div class="text-center mt-4">
                <a href="Sh.php" class="btn btn-primary">
                    <i class="fa fa-shopping-cart"></i> Continue Shopping
                </a>
            </div>
        <?php else: ?>
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
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td>$<?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                            <td><a href="?action=remove&id=<?php echo $id; ?>" class="btn btn-danger">Remove</a></td>
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
                <a href="checkout.php" class="btn btn-success btn-lg">
                    Proceed to Checkout
                </a>
            </div>
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
