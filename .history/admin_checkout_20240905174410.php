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

if (isset($_GET['order_id'])) {
    // Fetch order details for a specific order
    $order_id = (int) $_GET['order_id'];
    
    // Fetch order from the database
    $sql = "SELECT * FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();

    // Fetch order items from the database
    $sql = "SELECT * FROM order_items WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $items = $stmt->get_result();
} else {
    // Fetch all orders for the user
    $sql = "SELECT * FROM orders WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']); // Assuming user_id is stored in session
    $stmt->execute();
    $result = $stmt->get_result();
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Summary</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #ffecd2, #fcb69f);
        }
        .order-summary-container, .order-details-container {
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
    </style>
</head>
<body>
<?php include 'Unavbar.php'; ?>

<div class="container">
    <?php if (isset($order_id)): ?>
        <!-- Order Details -->
        <div class="order-details-container">
            <h1 class="text-center">Order Details</h1>
            <h3>Order ID: <?php echo htmlspecialchars($order['order_id']); ?></h3>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($order['order_date']); ?></p>
            <p><strong>Total:</strong> $<?php echo htmlspecialchars($order['total']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
            
            <h3>Items</h3>
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
                    <?php while ($item = $items->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td>$<?php echo htmlspecialchars($item['price']); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td>$<?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <!-- Order Summary -->
        <div class="order-summary-container">
            <h1 class="text-center">Order Summary</h1>
            <?php if ($result->num_rows > 0): ?>
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                                <td>$<?php echo htmlspecialchars($order['total']); ?></td>
                                <td><?php echo htmlspecialchars($order['status']); ?></td>
                                <td>
                                    <a href="order_summary.php?order_id=<?php echo htmlspecialchars($order['order_id']); ?>" class="btn btn-info btn-sm">View Details</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">No orders found.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'Footer.php'; ?>

<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
