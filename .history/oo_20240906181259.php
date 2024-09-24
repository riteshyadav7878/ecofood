<?php
session_start();

// Include the database connection
include 'conn.php';

// Initialize variables
$selected_user_id = null;
$view_summary = false;

// Check if a user ID is selected
if (isset($_POST['user_id']) && is_numeric($_POST['user_id'])) {
    $selected_user_id = intval($_POST['user_id']);
}

// Check if 'View Summary' button is clicked
if (isset($_POST['view_summary'])) {
    $view_summary = true;
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

        <?php if ($selected_user_id && !$view_summary) { ?>
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
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p>No orders found for this user.</p>
            <?php } ?>
            <!-- Button to view order summary -->
            <form method="post" class="text-center mt-4">
                <input type="hidden" name="user_id" value="<?php echo $selected_user_id; ?>">
                <button type="submit" name="view_summary" class="btn btn-secondary">View Order Summary</button>
            </form>
        <?php } ?>

        <?php if ($view_summary && $selected_user_id) {
            // Fetch order summary for the selected user
            $sql_summary = "SELECT o.order_id, o.full_name, o.email, SUM(o.total) as total_amount, COUNT(o.order_id) as total_orders
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
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo htmlspecialchars($summary['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($summary['email']); ?></td>
                            <td><?php echo $summary['total_orders']; ?></td>
                            <td>$<?php echo number_format($summary['total_amount'], 2); ?></td>
                        </tr>
                    </tbody>
                </table>
            <?php } else { ?>
                <p>No summary data found for this user.</p>
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
    if ($view_summary) {
        $stmt_summary->close();
    }
}
$result_total_users->free();
$conn->close();
?>
