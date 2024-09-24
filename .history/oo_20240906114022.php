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

// Fetch all orders
$sql = "SELECT * FROM cart_order";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order List</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
        .order-container {
            margin-top: 20px;
        }
        .order-details img {
            max-width: 100px;
            height: auto;
        }
        .order-details .product-image {
            width: 100px;
            height: auto;
        }
    </style>
</head>
<body>

<?php include 'Navbar.php'; ?>

<div class="container order-container">
    <h1>Order List</h1>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($order = $result->fetch_assoc()): ?>
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
                    
                    <?php
                    // Fetch items for this order
                    $orderId = $order['order_id'];
                    $sqlItems = "SELECT * FROM order_cart WHERE order_id = ?";
                    $stmtItems = $conn->prepare($sqlItems);
                    $stmtItems->bind_param("i", $orderId);
                    $stmtItems->execute();
                    $itemsResult = $stmtItems->get_result();
                    ?>

                    <h5>Items in this Order</h5>
                    <?php if ($itemsResult->num_rows > 0): ?>
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
                                    <?php while ($item = $itemsResult->fetch_assoc()): ?>
                                        <tr>
                                            <td>
                                                <?php if (!empty($item['image']) && file_exists("images/" . $item['image'])): ?>
                                                    <img src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['product_title']); ?>" class="product-image">
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
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p>No items found for this order.</p>
                    <?php endif; ?>

                    <?php
                    // Close items statement
                    $stmtItems->close();
                    ?>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>

</div>

<?php include 'Footer.php'; ?>

<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>

<?php
// Close the connection
$conn->close();
?>
