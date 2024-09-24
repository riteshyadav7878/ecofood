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

// Fetch order details if order_id is set
if (isset($_GET['order_id'])) {
    $orderId = intval($_GET['order_id']);

    // Fetch the order info with user details
    $sql = "SELECT c.*, u.username, u.email AS user_email 
            FROM cart_order c 
            JOIN user u ON c.user_id = u.id 
            WHERE c.order_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $orderResult = $stmt->get_result();
        if ($orderResult && $orderResult->num_rows > 0) {
            $order = $orderResult->fetch_assoc();
        }

        // Fetch the items in the order
        $sql = "SELECT * FROM order_cart WHERE order_id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $orderId);
            $stmt->execute();
            $itemsResult = $stmt->get_result();
        } else {
            echo "Error preparing statement for order items.";
        }
    } else {
        echo "Error preparing statement for order details.";
    }
} else {
    echo "Order ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card-body p {
            margin-bottom: 0.5rem;
        }
        .table img {
            max-width: 150px; /* Adjust width as needed */
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .table th, .table td {
            text-align: center;
        }
        .no-image {
            color: #777;
            font-style: italic;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2>Order Details</h2>

    <?php if ($order): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Order ID: <?php echo htmlspecialchars($order['order_id']); ?></h5>
                <p class="card-text">Full Name: <?php echo htmlspecialchars($order['full_name']); ?></p>
                <p class="card-text">Username: <?php echo htmlspecialchars($order['username']); ?></p>
                <p class="card-text">Email: <?php echo htmlspecialchars($order['user_email']); ?></p>
                <p class="card-text">Address: <?php echo htmlspecialchars($order['address']); ?></p>
                <p class="card-text">City: <?php echo htmlspecialchars($order['city']); ?></p>
                <p class="card-text">ZIP: <?php echo htmlspecialchars($order['zip']); ?></p>
                <p class="card-text">Total: ₹<?php echo number_format($order['total'], 2); ?></p>
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
                            // Construct the image path
                            $imagePath = "images/" . htmlspecialchars($item['image']);
                            // Check if the image file exists
                            $imageExists = file_exists($imagePath);
                            // Format price and total
                            $price = number_format((float)$item['price'], 2);
                            $itemTotal = number_format((float)$item['total'], 2);
                            ?>

                            <tr>
                                <td>
                                    <?php if ($imageExists): ?>
                                        <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($item['product_title']); ?>" />
                                    <?php else: ?>
                                        <p class="no-image">No Image</p>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($item['product_id']); ?></td>
                                <td><?php echo htmlspecialchars($item['product_title']); ?></td>
                                <td><?php echo '₹' . $price; ?></td>
                                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                <td><?php echo '₹' . $itemTotal; ?></td>
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
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?>
