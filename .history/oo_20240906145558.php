<?php
// Database connection
include 'db_connect.php'; // Ensure this file contains your database connection details

// Fetch all orders
$query = "SELECT * FROM cart_order"; // Adjust table name and fields as needed
$result = mysqli_query($conn, $query);

// Check if there are results
if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Overview</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
        .order-table {
            margin-top: 20px;
        }
        .order-table th, .order-table td {
            text-align: center;
        }
        .order-table img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>

<?php include 'Navbar.php'; ?>

<div class="container">
    <h1 class="my-4">Order Overview</h1>

    <table class="table table-bordered order-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>City</th>
                <th>ZIP</th>
                <th>Total</th>
                <th>Status</th>
                <th>Order Date</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                    <td><?php echo htmlspecialchars($row['city']); ?></td>
                    <td><?php echo htmlspecialchars($row['zip']); ?></td>
                    <td>$<?php echo htmlspecialchars($row['total']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                    <td><a href="order-details.php?id=<?php echo $row['order_id']; ?>" class="btn btn-info">View Details</a></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'Footer.php'; ?>

<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
