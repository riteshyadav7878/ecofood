<?php
// Start the session
session_start();

// Include database connection
include 'conn.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if the cart session exists and is not empty
$cart_empty = !isset($_SESSION['cart']) || empty($_SESSION['cart']);
$total = 0;

// Determine which section to display
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ecofood</title>
    <meta name="description" content="Ecofood - Order Summary & Home Page">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS Links -->
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #ffecd2, #fcb69f);
        }
        .order-summary-container, .home-container {
            background: #fff4e6;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        h1, h3 {
            font-size: 1.5rem;
        }
        .table {
            background: #ffe0b3;
            font-size: 1.875rem;
        }
        .table th, .table td {
            padding: 0.5rem;
        }
        .form-group label {
            font-size: 1.875rem;
        }
        .form-control {
            font-size: 1.875rem;
            height: calc(1.5em + 0.75rem + 2px);
            padding: 0.375rem 0.75rem;
        }
        .btn-primary {
            background-color: #ff7f50;
            border-color: #ff7f50;
            font-size: 2.875rem;
            padding: 0.5rem 1rem;
        }
        .btn-primary:hover {
            background-color: #ff6347;
            border-color: #ff6347;
        }
    </style>
</head>
<body>

<?php include 'Unavbar.php'; ?>

<section>
    <div class="section primary-color-background">
        <div class="container">
            <div class="p-t-70 p-b-85">
                <div class="heading-page-1">
                    <h3><?php echo $page === 'home' ? 'Home' : 'Order Summary & Billing Details'; ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="section border-bottom-grey">
        <div class="container">
            <div class="breadcrumb-1">
                <ul>
                    <li><a href="?page=home">Home</a></li>
                    <?php if ($page === 'order_summary'): ?>
                        <li><a href="?page=order_summary">Order Summary</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <?php if ($page === 'home'): ?>
        <div class="home-container">
            <!-- Home Page Content Here -->
            <h1>Welcome to Ecofood</h1>
            <p>Browse our products and enjoy your shopping experience.</p>
            <!-- Add more content or features for the home page -->
        </div>
    <?php elseif ($page === 'order_summary'): ?>
        <?php if ($cart_empty): ?>
            <div class="text-center mt-5">
                <h3 class="text-danger">No items in your cart</h3>
            </div>
        <?php else: ?>
            <div class="order-summary-container">
                <div class="row">
                    <!-- Order Summary -->
                    <div class="col-12 col-md-6">
                        <h3>Order Summary</h3>
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
                    </div>

                    <!-- Billing Details -->
                    <div class="col-12 col-md-6">
                        <h3>Billing Details</h3>
                        <form action="process_checkout.php" method="POST">
                            <div class="form-group">
                                <label for="fullName">Full Name</label>
                                <input type="text" class="form-control" id="fullName" name="fullName" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>
                            <div class="form-group">
                                <label for="zip">Zip Code</label>
                                <input type="text" class="form-control" id="zip" name="zip" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php include 'Footer.php'; ?>

<!-- JavaScript Files -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
