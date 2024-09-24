<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include your database connection file
include 'conn.php';

// Get the order ID from the URL
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

// Fetch order details from the database
$query = "SELECT * FROM orders WHERE order_id = $order_id";
$order_result = mysqli_query($conn, $query);

if (!$order_result) {
    die("Database query failed: " . mysqli_error($conn));
}

$order = mysqli_fetch_assoc($order_result);

// Fetch order items from the database
$items_query = "SELECT * FROM order_items WHERE order_id = $order_id";
$items_result = mysqli_query($conn, $items_query);

if (!$items_result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Details</title>
    <meta name="description" content="Order details page">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS Links -->
    <link href="fonts/fonts.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #ffecd2, #fcb69f); /* Vibrant background colors */
        }
        .order-details-container {
            background: #fff4e6; /* Light color to contrast with the background */
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        h1, h3 {
            font-size: 1.5rem; /* Smaller font size */
        }
        .table {
            background: #ffe0b3;
            font-size: 1.875rem; /* Smaller font size */
        }
        .table th, .table td {
            padding: 0.5rem; /* Smaller padding */
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
                    <h3>Order Details</h3>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="order-details-container">
        <h3>Order Summary</h3>
        <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order['order_id']); ?></p>
        <p><strong>Full Name:</strong> <?php echo htmlspecialchars($order['full_name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
        <p><strong>City:</strong> <?php echo htmlspecialchars($order['city']); ?></p>
        <p><strong>Zip Code:</strong> <?php echo htmlspecialchars($order['zip']); ?></p>
        <p><strong>Total:</strong> $<?php echo htmlspecialchars($order['total']); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
        <p><strong>Order Date:</strong> <?php echo htmlspecialchars($order['order_date']); ?></p>

        <h3>Order Items</h3>
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
                <?php while ($item = mysqli_fetch_assoc($items_result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['product_title']); ?></td>
                        <td>$<?php echo htmlspecialchars($item['product_price']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td>$<?php echo htmlspecialchars($item['product_price'] * $item['quantity']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'Footer.php'; ?>

<!-- JavaScript Files -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
