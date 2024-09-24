<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection
include 'conn.php';

// Get the ID of the most recent order for the logged-in user
$sql = "SELECT * FROM cart_order WHERE user_id = ? ORDER BY order_date DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$order_result = $stmt->get_result();
$order = $order_result->fetch_assoc();

// Fetch the products associated with the order
$sql = "SELECT * FROM order_cart WHERE order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order['order_id']);
$stmt->execute();
$product_result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            margin: 50px auto;
            width: 90%;
        }
        .details-table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container table-container">
        <h1 class="text-center">Thank You for Your Order!</h1>
        <p>Your order has been placed successfully. Here are the details:</p>

        <!-- Order Summary -->
        <div class="order-summary">
            <h3>Order Summary:</h3>
            <p><strong>Order ID:</strong> <?php echo $order['order_id']; ?></p>
            <p><strong>Full Name:</strong> <?php echo $order['full_name']; ?></p>
            <p><strong>Email:</strong> <?php echo $order['email']; ?></p>
            <p><strong>Address:</strong> <?php echo $order['address']; ?>, <?php echo $order['city']; ?></p>
            <p><strong>ZIP Code:</strong> <?php echo $order['zip']; ?></p>
            <p><strong>Total Amount:</strong> $<?php echo number_format($order['total'], 2); ?></p>
        </div>

        <!-- Product Details -->
        <h3>Products in this Order:</h3>
        <?php if ($product_result->num_rows > 0) { ?>
            <table class="table table-striped details-table">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Title</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($product = $product_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $product['product_id']; ?></td>
                            <td><?php echo $product['product_title']; ?></td>
                            <td>$<?php echo number_format($product['price'], 2); ?></td>
                            <td><?php echo $product['quantity']; ?></td>
                            <td>$<?php echo number_format($product['total'], 2); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No products found in this order.</p>
        <?php } ?>

        <a href="welcome.php" class="btn btn-primary">Continue Shopping</a>
    </div>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the statement and connection
$stmt->close();
$conn->close();
?>
