<?php
session_start();

// Include the database connection
include 'conn.php';

// Initialize variables
$selected_user_id = null;
$selected_order_id = null;

// Check if a user ID is selected
if (isset($_POST['user_id']) && is_numeric($_POST['user_id'])) {
    $selected_user_id = intval($_POST['user_id']);
}

// Check if an order ID is selected
if (isset($_POST['view_order_id']) && is_numeric($_POST['view_order_id'])) {
    $selected_order_id = intval($_POST['view_order_id']);
}

// Fetch all users
$sql_users = "SELECT DISTINCT u.id, u.username, u.email AS user_email 
              FROM cart_order o 
              JOIN user u ON o.user_id = u.id
              ORDER BY u.username";
$user_result = $conn->query($sql_users);

// Fetch orders for the selected user if a user ID is selected
if ($selected_user_id) {
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

// Fetch order items details if an order ID is selected
if ($selected_order_id) {
    $sql_order_items = "SELECT * FROM order_items WHERE order_id = ?";
    $stmt_order_items = $conn->prepare($sql_order_items);
    $stmt_order_items->bind_param("i", $selected_order_id);
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
        .order-table, .user-table, .order-items-table {
            margin-top: 20px;
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
                <button type="submit" class="btn btn-primary ml-2">View Orders</button>
            </div>
        </form>

        <?php if ($selected_user_id) { ?>
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
                                        <button type="submit" class="btn btn-info">View Details</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p>No orders found for this user.</p>
            <?php } ?>
        <?php } ?>

        <?php if ($selected_order_id) { ?>
            <h2 class="text-center mt-4">Order Details for Order ID <?php echo $selected_order_id; ?></h2>
            
            <?php if ($order_items_result->num_rows > 0) { ?>
                <table class="table table-striped order-items-table">
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
                <p>No details found for this order.</p>
            <?php } ?>
        <?php } ?>
    </div>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the statements and connection
if ($selected_user_id) {
    $stmt->close();
    $stmt_user_info->close();
}
if ($selected_order_id) {
    $stmt_order_items->close();
}
$result_total_users->free();
$conn->close();
?>
