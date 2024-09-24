<?php
// Include the database connection
include 'conn.php';

// Fetch all users who have placed orders
$sql_users = "SELECT DISTINCT u.id, u.username, u.email 
              FROM cart_order o 
              JOIN user u ON o.user_id = u.id
              ORDER BY u.username";
$user_result = $conn->query($sql_users);
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
        
        <?php if ($user_result->num_rows > 0) { ?>
            <form action="orders_details.php" method="GET" class="text-center">
                <div class="form-group">
                    <label for="user_id">Select User:</label>
                    <select id="user_id" name="user_id" class="form-control" required>
                        <option value="">Select a user</option>
                        <?php while ($row = $user_result->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['username']); ?> (<?php echo htmlspecialchars($row['email']); ?>)</option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">View Orders</button>
            </form>
        <?php } else { ?>
            <p>No users found.</p>
        <?php } ?>
    </div>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the result set and connection
$user_result->free();
$conn->close();
?>
