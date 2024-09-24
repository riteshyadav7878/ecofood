<?php
// Include the database connection
include 'conn.php';

// Check if user_id is provided
if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);

    // Fetch orders for the selected user
    $sql = "SELECT * FROM cart_order 
            WHERE user_id = ? 
            ORDER BY order_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $order_result = $stmt->get_result();

    // Fetch user information
    $sql_user = "SELECT username, email FROM user WHERE id = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("i", $user_id);
    $stmt_user->execute();
    $user_info = $stmt_user->get_result()->fetch_assoc();
} else {
    die("No user ID provided.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Orders</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .order-container {
            margin: 50px auto;
            width: 90%;
        }
        .order-table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container order-container">
        <h1 class="text-center">Orders for <?php echo htmlspecialchars($user_info['username']); ?> (<?php echo htmlspecialchars($user_info['email']); ?>)</h1>

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
                                <a href="order_details.php?order_id=<?php echo $row['order_id']; ?>" class="btn btn-info btn-sm">View Details</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No orders found for this user.</p>
        <?php } ?>

        <a href="billing_details.php" class="btn btn-primary">Back to Billing Details</a>
    </div>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the statements and connection
$stmt->close();
$stmt_user->close();
$conn->close();
?>
