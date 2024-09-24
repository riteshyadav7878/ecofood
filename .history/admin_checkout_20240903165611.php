<?php
// Start the session
session_start();

// Check if the admin is logged in
 
// Include your database connection file
include 'conn.php';

// Fetch order details from the database
// This example assumes you have a table named 'orders' to store order details
$query = "SELECT * FROM orders"; // Modify as per your database structure
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}

$total = 0;
?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Checkout - Ecofood HTML5 Templates</title>
    <meta name="description" content="Ecofood theme template">
    <meta name="author" content="AuCreative">
    <meta name="keywords" content="Ecofood theme template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #ffecd2, #fcb69f);
        }
        .admin-container {
            background: #fff4e6;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        h3 {
            font-size: 1.5rem;
        }
        .table {
            background: #ffe0b3;
            font-size: 1.5rem;
        }
        .table th, .table td {
            padding: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="admin-container">
            <h3>Order Management</h3>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Zip Code</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                            <td><?php echo htmlspecialchars($row['city']); ?></td>
                            <td><?php echo htmlspecialchars($row['zip']); ?></td>
                            <td>$<?php echo htmlspecialchars($row['total']); ?></td>
                            <td>
                                <a href="view_order.php?id=<?php echo $row['order_id']; ?>" class="btn btn-info">View</a>
                                <a href="delete_order.php?id=<?php echo $row['order_id']; ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        <?php $total += $row['total']; ?>
                    <?php endwhile; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" class="text-right font-weight-bold">Grand Total</td>
                        <td class="font-weight-bold">$<?php echo $total; ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>
