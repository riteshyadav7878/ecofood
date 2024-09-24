<?php
// Start the session
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin_username'])) {
    // Redirect to login page if not logged in as admin
    header("Location: admin_login.php");
    exit();
}

// Include your database connection file
include 'conn.php';

// Fetch orders from the database
$query = "SELECT * FROM orders ORDER BY order_date DESC";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
        }
        .table {
            background-color: #ffffff;
        }
        .btn {
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
<?php include 'admin_navbar.php'; ?>

<div class="container">
    <h1 class="mb-4">Orders</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td>$<?php echo htmlspecialchars($row['total']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td><?php echo htmlspecialchars(date('F j, Y, g:i a', strtotime($row['order_date']))); ?></td>
                    <td>
                        <a href="view_order.php?id=<?php echo $row['order_id']; ?>" class="btn btn-info btn-sm">View</a>
                        <a href="process_order.php?id=<?php echo $row['order_id']; ?>&action=complete" class="btn btn-success btn-sm" onclick="return confirm('Mark this order as completed?');">Complete</a>
                        <a href="process_order.php?id=<?php echo $row['order_id']; ?>&action=cancel" class="btn btn-danger btn-sm" onclick="return confirm('Cancel this order?');">Cancel</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- JavaScript Files -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
