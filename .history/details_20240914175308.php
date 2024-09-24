<?php
// Start the session
session_start();

// Include your database connection file
include 'conn.php';

// Fetch orders from the database
$query = "SELECT * FROM orders ORDER BY created_at DESC";
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
    <table class="table table-bordered table-striped">
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
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['total']); ?></td>
                    <td>
                        <?php
                        // Display status as a badge
                        $status = htmlspecialchars($row['status']);
                        if ($status == 'Pending') {
                            echo '<span class="badge bg-warning text-dark">Pending</span>';
                        } elseif ($status == 'Completed') {
                            echo '<span class="badge bg-success">Completed</span>';
                        } elseif ($status == 'Cancelled') {
                            echo '<span class="badge bg-danger">Cancelled</span>';
                        }
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    <td>
                        <!-- Actions can be added here, like view or edit -->
                        <a href="view_order.php?id=<?php echo htmlspecialchars($row['order_id']); ?>" class="btn btn-info btn-sm">View</a>
                        <!-- Add more action buttons if needed -->
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- JavaScript Files -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
