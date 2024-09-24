<?php
// Include the database connection
include 'conn.php';

// Initialize variables
$selected_user_id = null;
$username = null;

// Check if a user ID is selected
if (isset($_POST['user_id']) && is_numeric($_POST['user_id'])) {
    $selected_user_id = intval($_POST['user_id']);
}

// Fetch all users
$sql_users = "SELECT id, username FROM user ORDER BY username";
$user_result = $conn->query($sql_users);

// Fetch orders for the selected user if a user ID is selected
if ($selected_user_id) {
    $sql_orders = "SELECT o.*, u.username, u.email AS user_email 
                   FROM cart_order o 
                   JOIN user u ON o.user_id = u.id
                   WHERE o.user_id = ? 
                   ORDER BY o.order_date DESC";
    $stmt = $conn->prepare($sql_orders);
    $stmt->bind_param("i", $selected_user_id);
    $stmt->execute();
    $order_result = $stmt->get_result();
    
    // Fetch the username for the selected user
    $sql_username = "SELECT username FROM user WHERE id = ?";
    $stmt_username = $conn->prepare($sql_username);
    $stmt_username->bind_param("i", $selected_user_id);
    $stmt_username->execute();
    $result_username = $stmt_username->get_result();
    if ($user_row = $result_username->fetch_assoc()) {
        $username = $user_row['username'];
    }
} else {
    $order_result = null;
}

// Fetch the total number of users who have placed orders
$sql_users_count = "SELECT COUNT(DISTINCT user_id) AS user_count FROM cart_order";
$result_users_count = $conn->query($sql_users_count);
$user_count = $result_users_count->fetch_assoc()['user_count'];

// Close the statements and connection
if (isset($stmt)) {
    $stmt->close();
}
if (isset($stmt_username)) {
    $stmt_username->close();
}
$result_users_count->free();
$conn->close();
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

        <?php if ($selected_user_id && $order_result && $order_result->num_rows > 0) { ?>
            <h2 class="text-center mt-4">Orders for <?php echo htmlspecialchars($username); ?></h2>
            
            <table class="table table-striped order-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Username</th>
                        <th>User Email</th>
                        <th>Full Name</th>
                        <th>Total Amount</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $order_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['order_id']; ?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_email']); ?></td>
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
            <p class="text-center">No orders found for this user.</p>
        <?php } ?>
    </div>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
