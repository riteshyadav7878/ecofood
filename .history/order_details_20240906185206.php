<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card-text {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2>Order Details</h2>

    <?php if ($order): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Order ID: <?php echo $order['order_id']; ?></h5>
                <p class="card-text">Full Name: <?php echo $order['full_name']; ?></p>
                <p class="card-text">Email: <?php echo $order['email']; ?></p>
                <p class="card-text">Address: <?php echo $order['address']; ?></p>
                <p class="card-text">City: <?php echo $order['city']; ?></p>
                <p class="card-text">ZIP: <?php echo $order['zip']; ?></p>
                <p class="card-text">Total: ₹<?php echo $order['total']; ?></p>
                <p class="card-text">Status: <?php echo $order['status']; ?></p>
                <p class="card-text">Order Date: <?php echo $order['order_date']; ?></p>
            </div>
        </div>

        <h3>Items in this order</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Title</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = $itemsResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $item['product_id']; ?></td>
                            <td><?php echo $item['product_title']; ?></td>
                            <td><?php echo '₹' . $item['price']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo '₹' . $item['total']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <a href="index.php" class="btn btn-primary">Back to Orders</a>
    <?php else: ?>
        <p>Order not found.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php
// Close the statement and connection
$stmt->close();
$conn->close();
?>
