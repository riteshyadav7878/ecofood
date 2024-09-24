<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include your database connection file
include 'conn.php';

// Fetch all orders placed by the logged-in user
$userId = $_SESSION['user_id'];
$sql = "SELECT * FROM cart_order WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .table-hover tbody tr:hover {
            background-color: #f1f1f1; /* Light grey background on hover */
        }
        .btn-info {
            transition: background-color 0.3s, color 0.3s;
        }
        .btn-info:hover {
            background-color: #0056b3; /* Darker blue on hover */
            color: #fff;
        }
        .navbar {
            margin-bottom: 30px;
        }
        .container {
            margin-top: 20px;
        }
        .table th {
            background-color: #007bff; /* Blue background for headers */
            color: #ffffff;
        }
        .table td {
            background-color: #ffffff; /* Default white background for cells */
            transition: background-color 0.3s;
        }
        .table tbody tr:nth-child(even) td {
            background-color: #f9f9f9; /* Light grey for even rows */
        }
        .table tbody tr:nth-child(odd) td {
            background-color: #ffffff; /* White for odd rows */
        }
        .table tbody tr:hover td {
            background-color: #e9ecef; /* Light grey background on hover for cells */
        }
        .table td:first-child {
            background-color: #e2e3e5; /* Light gray for the first column */
        }
        .table td:nth-child(2) {
            background-color: #f8f9fa; /* Very light grey for the second column */
        }
        .table td:nth-child(3) {
            background-color: #e9ecef; /* Light grey for the third column */
        }
        .table td:nth-child(4) {
            background-color: #f1f3f5; /* Slightly different grey for the fourth column */
        }
        .table td:nth-child(5) {
            background-color: #f8f9fa; /* Alternate grey for the fifth column */
        }
        .table td:nth-child(6) {
            background-color: #e9ecef; /* Alternate grey for the sixth column */
        }
        .table td:nth-child(7) {
            background-color: #f1f3f5; /* Alternate grey for the seventh column */
        }
        .table td:nth-child(8) {
            background-color: #f8f9fa; /* Alternate grey for the eighth column */
        }
        .table td:nth-child(9) {
            background-color: #e9ecef; /* Alternate grey for the ninth column */
        }
        .table td:nth-child(10) {
            background-color: #f1f3f5; /* Alternate grey for the tenth column */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#">YourSite</a>
</nav>

<div class="container mt-5">
    <h2>Your Orders</h2>
    
    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Order ID</th>
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
                    <?php while ($order = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['email']); ?></td>
                            <td><?php echo htmlspecialchars($order['address']); ?></td>
                            <td><?php echo htmlspecialchars($order['city']); ?></td>
                            <td><?php echo htmlspecialchars($order['zip']); ?></td>
                            <td><?php echo '₹' . htmlspecialchars($order['total']); ?></td>
                            <td><?php echo htmlspecialchars($order['status']); ?></td>
                            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                            <td>
                                <a href="order_details.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-info">View Details</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
// Close the statement and connection
$stmt->close();
$conn->close();
?>
