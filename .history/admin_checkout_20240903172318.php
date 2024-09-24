<?php
// Start the session
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirect to login page if not logged in as admin
    header("Location: admin_login.php");
    exit();
}

// Include your database connection file
include 'conn.php';

// Fetch orders and their items from the database
$query = "SELECT * FROM orders";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Order Checkout</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
        body {
            background: #f4f4f4;
        }
        .container {
            margin-top: 30px;
        }
        .order-container {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        }
        h3 {
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="order-container">
        <h3>Orders</h3>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($order = $result->fetch_assoc()): ?>
                <div class="order-details">
                    <h4>Order ID: <?php echo htmlspecialchars($order['order_id']); ?></h4>
                    <p><strong>Full Name:</strong> <?php echo htmlspecialchars($order['full_name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
                    <p><strong>Address:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
                    <p><strong>City:</strong> <?php echo htmlspecialchars($order['city']); ?></p>
                    <p><strong>Zip Code:</strong> <?php echo htmlspecialchars($order['zip']); ?></p>
                    <p><strong>Total:</strong> $<?php echo htmlspecialchars($order['total']); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
                    <p><strong>Order Date:</strong> <?php echo htmlspecialchars($order['order_date']); ?></p>
                    <h5>Order Items</h5>
                    
                    <?php
                    $order_id = $order['order_id'];
                    $item_query = "SELECT * FROM order_items WHERE order_id = $order_id";
                    $item_result = $conn->query($item_query);
                    ?>
                    
                    <?php if ($item_result->num_rows > 0): ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($item = $item_result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['title']); ?></td>
                                        <td>$<?php echo htmlspecialchars($item['price']); ?></td>
                                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                        <td>$<?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No items found for this order.</p>
                    <?php endif; ?>

                    <a href="edit_order.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-primary">Edit Order</a>
                    <hr>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>

    </div>
</div>

<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
