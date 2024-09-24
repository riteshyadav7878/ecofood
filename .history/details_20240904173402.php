<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Check if the cart session exists and is not empty
$cart_empty = !isset($_SESSION['cart']) || empty($_SESSION['cart']);
$total = 0;
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart - Ecofood HTML5 Templates</title>
    <meta name="description" content="Ecofood theme template">
    <meta name="author" content="AuCreative">
    <meta name="keywords" content="Ecofood theme template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS Links -->
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">

    <style>
        body {
            background: #f4f4f4; /* Light background color */
        }
        .cart-container {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        h1, h3 {
            font-size: 1.5rem; /* Smaller font size */
        }
        .table {
            background: #fff;
            font-size: 1rem; /* Medium font size */
        }
        .table th, .table td {
            padding: 0.75rem; /* Medium padding */
        }
        .btn-primary {
            background-color: #ff7f50;
            border-color: #ff7f50;
            font-size: 1rem; /* Medium font size */
            padding: 0.5rem 1rem; /* Medium button */
        }
        .btn-primary:hover {
            background-color: #ff6347;
            border-color: #ff6347;
        }
    </style>
</head>
<body>

<?php include 'Unavbar.php'; ?>

<div class="container">
    <h1 class="text-center">Your Cart</h1>
    <?php if ($cart_empty): ?>
        <div class="text-center mt-5">
            <h3 class="text-danger">Your cart is empty</h3>
        </div>
    <?php else: ?>
        <div class="cart-container">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['title']); ?></td>
                                    <td>$<?php echo htmlspecialchars($item['price']); ?></td>
                                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                    <td>$<?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                                    <?php $total += $item['price'] * $item['quantity']; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right font-weight-bold">Total</td>
                                <td class="font-weight-bold">$<?php echo $total; ?></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="text-center mt-4">
                        <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'Footer.php'; ?>

<!-- JavaScript Files -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>

</body>
</html>
