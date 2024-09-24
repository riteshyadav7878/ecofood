<?php
// Include the database connection
include 'conn.php';

// Fetch all orders along with user information
$sql = "SELECT o.*, u.username, u.email AS user_email 
        FROM cart_order o 
        JOIN user u ON o.user_id = u.user_id
        ORDER BY o.order_date DESC";
$order_result = $conn->query($sql);

// Fetch the total number of users who have placed orders
$sql_users = "SELECT COUNT(DISTINCT user_id) AS user_count FROM cart_order";
$result_users = $conn->query($sql_users);
$user_count = $result_users->fetch_assoc()['user_count'];
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

        <?php if ($order_result->num_rows > 0) { ?>
            <table class="table table-striped order-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Username</th>
                        <th>User Email</th>
                        <th>Full Name</th>
                        <th>Email</th>
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
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['user_email']; ?></td>
                            <td><?php echo $row['full_name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td>$<?php echo number_format($row['total'], 2); ?></td>
                            <td><?php echo date("d-m-Y H:i", strtotime($row['order_date'])); ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <a href="order_details.php?order_id=<?php echo $row['order_id']; ?>" class="btn btn-info btn-sm">View</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No orders found.</p>
        <?php } ?>
    </div>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the result set and connection
$result_users->free();
$conn->close();
?>
