<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include your database connection
include 'conn.php';

// Check if the cart session exists and is not empty
$cart_empty = !isset($_SESSION['cart']) || empty($_SESSION['cart']);
$total = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$cart_empty) {
    // Retrieve and sanitize user input
    $fullName = htmlspecialchars($_POST['fullName']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $city = htmlspecialchars($_POST['city']);
    $zip = htmlspecialchars($_POST['zip']);
    
    // Calculate the total from the cart
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Insert into cart_order table
    $stmt = $conn->prepare("INSERT INTO cart_order (user_id, full_name, email, address, city, zip, total) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('isssssd', $_SESSION['user_id'], $fullName, $email, $address, $city, $zip, $total);
    
    if ($stmt->execute()) {
        // Get the last inserted order ID
        $order_id = $conn->insert_id;

        // Insert each item into the order_items table
        $stmt_items = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_title, price, quantity, total) VALUES (?, ?, ?, ?, ?, ?)");
        
        foreach ($_SESSION['cart'] as $id => $item) {
            $item_total = $item['price'] * $item['quantity'];
            $stmt_items->bind_param('iisidd', $order_id, $id, $item['title'], $item['price'], $item['quantity'], $item_total);
            $stmt_items->execute();
        }

        // Clear the cart
        unset($_SESSION['cart']);
        
        // Redirect to a success page
        header("Location: success.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS Links -->
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #ffecd2, #fcb69f);
        }
        .checkout-container {
            background: #fff4e6;
            border-radius: 8px;
            padding: 20px;
            margin-top: 30px;
        }
        .btn-primary {
            background-color: #ff7f50;
        }
        .btn-primary:hover {
            background-color: #ff6347;
        }
    </style>
</head>
<body>

<?php include 'Unavbar.php'; ?>

<div class="container">
    <?php if ($cart_empty): ?>
        <div class="text-center mt-5">
            <h3 class="text-danger">No items found in your cart.</h3>
        </div>
    <?php else: ?>
        <div class="checkout-container">
            <div class="row">
                <!-- Order Summary -->
                <div class="col-md-6">
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
                            <?php foreach ($_SESSION['cart'] as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['title']); ?></td>
                                    <td>$<?php echo htmlspecialchars($item['price']); ?></td>
                                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                    <td>$<?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
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
                <div class="col-md-6">
                    <h3>Billing Details</h3>
                    <form action="checkout.php" method="POST">
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
</div>

<?php include 'Footer.php'; ?>

<!-- JavaScript Files -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>

</body>
</html>
