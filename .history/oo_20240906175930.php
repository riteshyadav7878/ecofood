<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection
include 'conn.php';

// Initialize variables
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ($user_id) {
    // Fetch orders for the selected user
    $sql_orders = "SELECT * FROM cart_order WHERE user_id = ? ORDER BY order_date DESC";
    $stmt_orders = $conn->prepare($sql_orders);
    $stmt_orders->bind_param("i", $user_id);
    $stmt_orders->execute();
    $order_result = $stmt_orders->get_result();

    // Fetch user information
    $sql_user = "SELECT username, email FROM user WHERE id = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("i", $user_id);
    $stmt_user->execute();
    $user_info = $stmt_user->get_result()->fetch_assoc();
}

if ($order_id) {
    // Fetch the order details
    $sql_order = "SELECT * FROM cart_order WHERE order_id = ?";
    $stmt_order = $conn->prepare($sql_order);
    $stmt_order->bind_param("i", $order_id);
    $stmt_order->execute();
    $order_result = $stmt_order->get_result();
    $order = $order_result->fetch_assoc();

    // Fetch the products associated with the order
    $sql_products = "SELECT * FROM order_cart WHERE order_id = ?";
    $stmt_products = $conn->prepare($sql_products);
    $stmt_products->bind_param("i", $order_id);
    $stmt_products->execute();
    $product_result = $stmt_products->get_result();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Orders and Details</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            margin: 50px auto;
            width: 90%;
        }
        .order-table, .details-table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container table-container">
        <?php if (!$order_id) { ?>
            <h1 class="text-center">Billing Details</h1>

            <?php if ($user_id) { ?>
                <h2 class="text-center">Orders for <?php echo htmlspecialchars($user_info['username']); ?> (<?php echo htmlspecialchars($user_info['email']); ?>)</h2>

                <?php if ($order_result->num_rows > 0) { ?>
                    <table class="table table-striped order-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Full Name</th>
                                <th>Total Amount</th>
                                <th>Order Date</th>
                                <th>Status</th>
                                <th>View Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $order_result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                    <td>$<?php echo number_format($row['total'], 2); ?></td>
                                    <td><?php echo date("d-m-Y H:i", strtotime($row['order_date'])); ?></td>
                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                    <td>
                                        <a href="user_orders_details.php?user_id=<?php echo $user_id; ?>&order_id=<?php echo $row['order_id']; ?>" class="btn btn-info btn-sm">View Details</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p>No orders found for this user.</p>
                <?php } ?>

                <a href="user_orders_details.php" class="btn btn-primary">Back to Select User</a>

            <?php } else { ?>
                <h1 class="text-center">Select a User</h1>

                <?php
                // Fetch all users who have placed orders
                $sql_users = "SELECT DISTINCT u.id, u.username, u.email 
                              FROM cart_order o 
                              JOIN user u ON o.user_id = u.id
                              ORDER BY u.username";
                $user_result = $conn->query($sql_users);

                if ($user_result->num_rows > 0) { ?>
                    <form action=".php" method="GET" class="text-center">
                        <div class="form-group">
                            <label for="user_id">Select User:</label>
                            <select id="user_id" name="user_id" class="form-control" required>
                                <option value="">Select a user</option>
                                <?php while ($row = $user_result->fetch_assoc()) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['username']); ?> (<?php echo htmlspecialchars($row['email']); ?>)</option>
                                <?php } ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">View Orders</button>
                    </form>
                <?php } else { ?>
                    <p>No users found.</p>
                <?php } ?>
            <?php } ?>

        <?php } else { ?>
            <h1 class="text-center">Order Summary</h1>

            <!-- Order Summary -->
            <div class="order-summary">
                <h3>Order Summary:</h3>
                <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order['order_id']); ?></p>
                <p><strong>Full Name:</strong> <?php echo htmlspecialchars($order['full_name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($order['address']); ?>, <?php echo htmlspecialchars($order['city']); ?>, <?php echo htmlspecialchars($order['zip']); ?></p>
                <p><strong>Total Amount:</strong> $<?php echo number_format($order['total'], 2); ?></p>
                <p><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
                <p><strong>Order Date:</strong> <?php echo date("d-m-Y H:i", strtotime($order['order_date'])); ?></p>
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
                                <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                                <td><?php echo htmlspecialchars($product['product_title']); ?></td>
                                <td>$<?php echo number_format($product['price'], 2); ?></td>
                                <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                                <td>$<?php echo number_format($product['total'], 2); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p>No products found in this order.</p>
            <?php } ?>

            <a href="user_orders_details.php?user_id=<?php echo $user_id; ?>" class="btn btn-primary">Back to Orders</a>
            <a href="user_orders_details.php" class="btn btn-secondary">Back to Select User</a>
        <?php } ?>
    </div>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the statements and connection
if (isset($stmt_orders)) $stmt_orders->close();
if (isset($stmt_user)) $stmt_user->close();
if (isset($stmt_order)) $stmt_order->close();
if (isset($stmt_products)) $stmt_products->close();
$conn->close();
?>
