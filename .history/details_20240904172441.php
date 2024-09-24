<?php
// Start the session
session_start();

// Include your database connection file
include 'conn.php';

// Fetch records from the database
$query = "SELECT * FROM orders"; // Change 'orders' to your actual table name
$result = $conn->query($query);

// Check if query was successful
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Records - Your Website</title>
    <meta name="description" content="Records page">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS Links -->
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">

    <style>
        body {
            background: #f4f4f4; /* Light background color */
        }
        .container {
            margin-top: 30px;
            max-width: 1200px; /* Medium size for the page output */
        }
        .table {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            padding: 1rem;
            font-size: 1rem; /* Medium font size */
        }
        .table thead {
            background-color: #343a40;
            color: #fff;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<?php include 'Unavbar.php'; ?>

<div class="container">
    <h1 class="text-center">Records</h1>
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>City</th>
                <th>Zip Code</th>
                <th>Total</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['order_id'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row['full_name'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row['email'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row['address'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row['city'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row['zip'] ?? 'N/A'); ?></td>
                        <td>$<?php echo htmlspecialchars($row['total'] ?? '0.00'); ?></td>
                        <td><?php echo htmlspecialchars($row['order_date'] ?? 'N/A'); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">No records found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include 'Footer.php'; ?>

<!-- JavaScript Files -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
