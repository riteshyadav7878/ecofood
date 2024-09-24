<?php
// Include the database connection
include 'conn.php';

// Fetch all users who have placed orders
$sql_users = "SELECT DISTINCT u.id, u.username, u.email
              FROM cart_order o
              JOIN user u ON o.user_id = u.id
              ORDER BY u.username";
$result_users = $conn->query($sql_users);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            margin: 50px auto;
            width: 90%;
        }
        .user-table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container table-container">
        <h1 class="text-center">User List</h1>

        <?php if ($result_users->num_rows > 0) { ?>
            <table class="table table-striped user-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>View Orders</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_users->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td>
                                <a href="order_details.php?user_id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">View Orders</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
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
$result_users->free();
$conn->close();
?>
