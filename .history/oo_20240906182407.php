<?php
session_start();

// Include the database connection
include 'conn.php';

// Initialize variables
$selected_user_id = null;
$view_summary = false;
$view_order_id = null;

// Check if a user ID is selected
if (isset($_POST['user_id']) && is_numeric($_POST['user_id'])) {
    $selected_user_id = intval($_POST['user_id']);
}

// Check if 'View Summary' or 'View Orders' button is clicked
if (isset($_POST['view_summary'])) {
    $view_summary = true;
} elseif (isset($_POST['view_orders'])) {
    $view_summary = false;
} elseif (isset($_POST['view_order_id'])) {
    $view_order_id = intval($_POST['view_order_id']);
}

// Fetch all users
$sql_users = "SELECT DISTINCT u.id, u.username, u.email AS user_email 
              FROM cart_order o 
              JOIN user u ON o.user_id = u.id
              ORDER BY u.username";
$user_result = $conn->query($sql_users);

// Fetch orders for the selected user if a user ID is selected
if ($selected_user_id && !$view_summary) {
    $sql_orders = "SELECT * FROM cart_order WHERE user_id = ? ORDER BY order_date DESC";
    $stmt = $conn->prepare($sql_orders);
    $stmt->bind_param("i", $selected_user_id);
    $stmt->execute();
    $order_result = $stmt->get_result();

    // Fetch user information
    $sql_user_info = "SELECT username, email FROM user WHERE id = ?";
    $stmt_user_info = $conn->prepare($sql_user_info);
    $stmt_user_info->bind_param("i", $selected_user_id);
    $stmt_user_info->execute();
    $user_info_result = $stmt_user_info->get_result();
    $user_info = $user_info_result->fetch_assoc();
}

// Fetch the total number of users who have placed orders
$sql_total_users = "SELECT COUNT(DISTINCT user_id) AS user_count FROM cart_order";
$result_total_users = $conn->query($sql_total_users);
$user_count = $result_total_users->fetch_assoc()['user_count'];

// Fetch order details for the view_order_id if set
if ($view_order_id) {
    $sql_order_details = "SELECT * FROM cart_order WHERE order_id = ?";
    $stmt_order_details = $conn->prepare($sql_order_details);
    $stmt_order_details->bind_param("i", $view_order_id);
    $stmt_order_details->execute();
    $order_details_result = $stmt_order_details->get_result();
    $order_details = $order_details_result->fetch_assoc();

    // Fetch products for the order
    $sql_order_items = "SELECT oi.product_name, oi.quantity, oi.price, oi.total 
                        FROM order_items oi
                        WHERE oi.order_id = ?";
    $stmt_order_items = $conn->prepare($sql_order_items);
    $stmt_order_items->bind_param("i", $view_order_id);
    $stmt_order_items->execute();
    $order_items_result = $stmt_order_items->get_result();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Details</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            margin: 50px auto;
            width: 90%;
        }
        .order-table, .user-table {
            margin-top: 20px;
        }
        .btn-view-summary {
            background-color: #007bff;
            color: white;
        }
        .btn-view-summary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container table-container">
        <h1 class="text-center">Billing Details</h1>
        
        <p class="text-center"><strong>Total Users Who Have Placed Orders:</strong> <?php echo $user_count; ?></p>

        <!-- Form to select a user -->
        <form method="post" class="text-center">
            <div class="form-group">
                <label for="user_id">Select User:</label>
                <select id="user_id" name="user_id" class="form-control" style="width: auto; display: inline-block;">
                    <option value="">--Select User--</option>
                    <?php while ($row = $user_result->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id']; ?>" <?php if ($selected_user_id == $row['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($row['username']); ?>
                        </option>
                    <?php } ?>
                </select>
                <button type="submit" name="view_orders" class="btn btn-primary ml-2">View Orders</button>
                <button type="submit" name="view_summary" class="btn btn-secondary ml-2">View Order Summary</button>
            </div>
        </form>

        <?php if ($selected_user_id) { ?>
            <?php if (!$view_summary) { ?>
                <h2 class="text-center mt-4">Orders for <?php echo htmlspecialchars($user_info['username']); ?></h2>
                
                <?php if ($order_result->num_rows > 0) { ?>
                    <table class="table table-striped order-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Total Amount</th>
                                <th>Order Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $order_result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['order_id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td>$<?php echo number_format($row['total'], 2); ?></td>
                                    <td><?php echo date("d-m-Y H:i", strtotime($row['order_date'])); ?></td>
                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                    <td>
                                        <form method="post" class="d-inline">
                                            <input type="hidden" name="view_order_id" value="<?php echo $row['order_id']; ?>">
                                            <button type="submit" class="btn btn-view-summary">View Summary</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p>No orders found for this user.</p>
                <?php } ?>
            <?php } else { ?>
                <?php
                // Fetch order summary for the selected user
                $sql_summary = "SELECT o.full_name, o.email, SUM(o.total) as total_amount, COUNT(o.order_id) as total_orders
                                FROM cart_order o
                                WHERE o.user_id = ?
                                GROUP BY o.user_id";
                $stmt_summary = $conn->prepare($sql_summary);
                $stmt_summary->bind_param("i", $selected_user_id);
                $stmt_summary->execute();
                $summary_result = $stmt_summary->get_result();
                $summary = $summary_result->fetch_assoc();
                ?>
                <h2 class="text-center mt-4">Order Summary for <?php echo htmlspecialchars($user_info['username']); ?></h2>
                
                <?php if ($summary) { ?>
                    <table class="table table-striped order-table">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Total Orders</th>
                                <th>Total Amount</th>
                                <th>Order Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo htmlspecialchars($summary['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($summary['email']); ?></td>
                                <td><?php echo $summary['total_orders']; ?></td>
                                <td>$<?php echo number_format($summary['total_amount'], 2); ?></td>
                                <td>
                                    <form method="post" class="d-inline">
                                        <input type="hidden" name="view_order_id" value="<?php echo $summary['order_id']; ?>">
                                        <button type="submit" class="btn btn-view-summary">View Order Details</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p>No summary data found for this user.</p>
                <?php } ?>
            <?php } ?>
        <?php } ?>

        <?php if ($view_order_id) { ?>
            <h2 class="text-center mt-4">Order Details for Order ID <?php echo $view_order_id; ?></h2>
            
            <?php if ($order_details) { ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>ZIP Code</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $order_details['order_id']; ?></td>
                            <td><?php echo htmlspecialchars($order_details['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($order_details['email']); ?></td>
                            <td><?php echo htmlspecialchars($order_details['address']); ?></td>
                            <td><?php echo htmlspecialchars($order_details['city']); ?></td>
                            <td><?php echo htmlspecialchars($order_details['zip']); ?></td>
                            <td>$<?php echo number_format($order_details['total'], 2); ?></td>
                            <td><?php echo htmlspecialchars($order_details['status']); ?></td>
                            <td><?php echo date("d-m-Y H:i", strtotime($order_details['order_date'])); ?></td>
                        </tr>
                    </tbody>
                </table>

                <h3 class="text-center mt-4">Ordered Products</h3>
                <?php if ($order_items_result->num_rows > 0) { ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($item = $order_items_result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                                    <td>$<?php echo number_format($item['total'], 2); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p>No products found for this order.</p>
                <?php } ?>
            <?php } else { ?>
                <p>Order details not found.</p>
            <?php } ?>
        <?php } ?>
    </div>
</body>
</html>
