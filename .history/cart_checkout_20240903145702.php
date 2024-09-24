<?php
session_start();
include 'conn.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Handle removal of an item from the cart
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);

        if (empty($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }
    }

    header('Location: cart_checkout.php');
    exit();
}

// Handle checkout form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];
    $phone = $_POST['phone'];
    $username = $_SESSION['username'];
    $total = 0;

    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Insert order into the database
    $query = "INSERT INTO orders (username, name, address, city, zip, phone, total) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssssss', $username, $name, $address, $city, $zip, $phone, $total);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    // Insert order items
    foreach ($_SESSION['cart'] as $id => $item) {
        $query = "INSERT INTO order_items (order_id, product_id, title, price, quantity) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('iisdi', $order_id, $id, $item['title'], $item['price'], $item['quantity']);
        $stmt->execute();
    }

    // Clear the cart
    unset($_SESSION['cart']);

    $checkout_success = true;
} else {
    $checkout_success = false;
}

$total = 0;
if (!$checkout_success && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
<meta charset="UTF-8">
<title>Cart/Checkout - Ecofood HTML5 Templates</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="fonts/fonts.css" rel="stylesheet">
<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="css/switcher.css" rel="stylesheet">
<link href="css/colors/green.css" rel="stylesheet" id="colors">
<script src="js/modernizr-custom.js"></script>
</head>
<body>

<header>
    <?php include 'Navbar.php'; ?>
</header>

<section>
    <div class="section primary-color-background">
        <div class="container">
            <div class="p-t-70 p-b-85">
                <div class="heading-page-1">
                    <h3><?php echo $checkout_success ? 'Thank You for Your Purchase!' : 'Shopping Cart / Checkout'; ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="section border-bottom-grey">
        <div class="container">
            <div class="breadcrumb-1">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="cart_checkout.php">Cart / Checkout</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="cart-checkout-section">
    <div class="container">
        <?php if ($checkout_success): ?>
            <h1>Your Order Has Been Placed Successfully!</h1>
            <p>Thank you for shopping with us. You will receive an email confirmation shortly.</p>
            <a href="index.php" class="btn btn-primary">Return to Home</a>
        <?php else: ?>
            <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
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
                <h2>Shipping Information</h2>
                <form action="cart_checkout.php" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city" name="city" required>
                    </div>
                    <div class="form-group">
                        <label for="zip">Zip Code</label>
                        <input type="text" class="form-control" id="zip" name="zip" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <button type="submit" class="btn btn-success">Place Order</button>
                </form>
            <?php else: ?>
                <h1>Your cart is empty!</h1>
                <a href="index.php" class="btn btn-primary">Return to Home</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<footer>
    <?php include 'Footer.php'; ?>
</footer>

<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
