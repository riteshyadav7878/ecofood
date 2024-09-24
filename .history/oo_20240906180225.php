<?php
session_start();

// Include the database connection
include 'conn.php';

// Fetch all users who have placed orders
$sql_users = "SELECT DISTINCT u.id, u.username, u.email 
              FROM cart_order o 
              JOIN user u ON o.user_id = u.id
              ORDER BY u.username";
$user_result = $conn->query($sql_users);

// Fetch the total number of users who have placed orders
$sql_user_count = "SELECT COUNT(DISTINCT user_id) AS user_count FROM cart_order";
$result_user_count = $conn->query($sql_user_count);
$user_count = $result_user_count->fetch_assoc()['user_count'];

// Fetch orders based on selected user
$selected_user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
if ($selected_user_id) {
    $sql_orders = "SELECT o.*, u.username, u.email AS user_email 
                   FROM cart_order o 
                   JOIN user u ON o.user_id = u.id
                   WHERE u.id = ?
                   ORDER BY o.order_date DESC";
    $stmt_orders = $conn->prepare($sql_orders);
    $stmt_orders->bind_param("i", $selected_user_id);
    $stmt_orders->execute();
    $order_result = $stmt_orders->get_result();
} else {
    $order_result = null;
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
        .order-table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container table-container">
        <h1 class="text-center">Billing Details</h1>
        
        <p class="text-center"><strong>Total Users Who Have Placed Orders:</strong> <?php echo $user_count; ?></p>

        <form action="billing_details.php" method="GET" class="text-center">
            <div class="form-group">
                <label for="user_id">Select User:</label>
                <select id="user_id" name="user_id" class="form-control" required>
                    <option value="">Select a user</option>
                    <?php while ($row = $user_result->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id']; ?>" <?php echo ($selected_user_id == $row['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($row['username']); ?> (<?php echo htmlspecialchars($row['email']); ?>)
                        </option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">View Orders</button>
        </form>

        <?php if ($selected_user_id && $order_result && $order_result->num_rows > 0) { ?>
            <h2 class="text-center">Orders for <?php echo htmlspecialchars($row['username']); ?></h2>
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
                                <a href="order_details.php?order_id=<?php echo $row['order_id']; ?>" class="btn btn-info btn-sm">View Details</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } elseif ($selected_user_id) { ?>
            <p>No orders found for this user.</p>
        <?php } ?>
    </div>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the result sets and connection
$result_user_count->free();
if (isset($stmt_orders)) $stmt_orders->close();
$conn->close();
?>
