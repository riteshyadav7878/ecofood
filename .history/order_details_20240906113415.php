<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include your database connection file
include 'conn.php';

// Initialize variables
$order = null;
$itemsResult = null;

// Fetch order details
if (isset($_GET['order_id'])) {
    $orderId = intval($_GET['order_id']);

    // Fetch the order info
    $sql = "SELECT * FROM cart_order WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $orderResult = $stmt->get_result();
    $order = $orderResult->fetch_assoc();

    // Fetch the items in the order
    $sql = "SELECT * FROM order_cart WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $itemsResult = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Order Details</h2>

    <?php if ($order): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Order ID: <?php echo htmlspecialchars($order['order_id']); ?></h5>
                <p class="card-text">Full Name: <?php echo htmlspecialchars($order['full_name']); ?></p>
                <p class="card-text">Email: <?php echo htmlspecialchars($order['email']); ?></p>
                <p class="card-text">Address: <?php echo htmlspecialchars($order['address']); ?></p>
                <p class="card-text">City: <?php echo htmlspecialchars($order['city']); ?></p>
                <p class="card-text">ZIP: <?php echo htmlspecialchars($order['zip']); ?></p>
                <p class="card-text">Total: ₹<?php echo htmlspecialchars($order['total']); ?></p>
                <p class="card-text">Status: <?php echo htmlspecialchars($order['status']); ?></p>
                <p class="card-text">Order Date: <?php echo htmlspecialchars($order['order_date']); ?></p>
            </div>
        </div>

        <h3>Items in this Order</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product ID</th>
                        <th>Product Title</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($itemsResult && $itemsResult->num_rows > 0): ?>
                        <?php while ($item = $itemsResult->fetch_assoc()): ?>
                            <?php 
                            // Debugging: output image path
                            $imagePath = "images/" . htmlspecialchars($item['image']);
                            ?>

                            <tr>
                                <td>
                                    <?php if (!empty($item['image']) && file_exists($imagePath)): ?>
                                        <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($item['product_title']); ?>" width="50">
                                    <?php else: ?>
                                        <p>No Image</p>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($item['product_id']); ?></td>
                                <td><?php echo htmlspecialchars($item['product_title']); ?></td>
                                <td><?php echo '₹' . htmlspecialchars($item['price']); ?></td>
                                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                <td><?php echo '₹' . htmlspecialchars($item['total']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No items found for this order.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <a href="index.php" class="btn btn-primary">Back to Orders</a>
    <?php else: ?>
        <p>Order not found.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php
// Close the statement and connection
$stmt->close();
$conn->close();
?>
