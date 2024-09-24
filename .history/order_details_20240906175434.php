<?php
// Include the database connection
include 'conn.php';

// Check if order_id is provided
if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);

    // Fetch order details
    $sql = "SELECT * FROM cart_order WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();

    // Fetch order items
    $sql_items = "SELECT * FROM order_items WHERE order_id = ?";
    $stmt_items = $conn->prepare($sql_items);
    $stmt_items->bind_param("i", $order_id);
    $stmt_items->execute();
    $items_result = $stmt_items->get_result();
} else {
    die("No order ID provided.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .order-details-container {
            margin: 50px auto;
            width: 90%;
        }
        .order-table, .items-table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container order-details-container">
        <h1 class="text-center">Order Details - #<?php echo htmlspecialchars($order['order_id']); ?></h1>

        <h2>Order Summary</h2>
        <table class="table table-striped order-table">
            <tr>
                <th>Full Name</th>
                <td><?php echo htmlspecialchars($order['full_name']); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($order['email']); ?></td>
            </tr>
            <tr>
                <th>Address</th>
                <td><?php echo htmlspecialchars($order['address']); ?></td>
            </tr>
            <tr>
                <th>City</th>
                <td><?php echo htmlspecialchars($order['city']); ?></td>
            </tr>
            <tr>
                <th>ZIP</th>
                <td><?php echo htmlspecialchars($order['zip']); ?></td>
            </tr>
            <tr>
                <th>Total Amount</th>
                <td>$<?php echo number_format($order['total'], 2); ?></td>
            </tr>
            <tr>
                <th>Order Date</th>
                <td><?php echo date("d-m-Y H:i", strtotime($order['order_date'])); ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?php echo htmlspecialchars($order['status']); ?></td>
            </tr>
        </table>

        <h2>Order Items</h2>
        <?php if ($items_result->num_rows > 0) { ?>
            <table class="table table-striped items-table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = $items_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td>$<?php echo number_format($item['total'], 2); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No items found for this order.</p>
        <?php } ?>

        <a href="user_orders.php?user_id=<?php echo $order['user_id']; ?>" class="btn btn-primary">Back to User Orders</a>
    </div>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the statements and connection
$stmt->close();
$stmt_items->close();
$conn->close();
?>
