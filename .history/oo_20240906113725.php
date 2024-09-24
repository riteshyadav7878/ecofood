<?php
// Include your database connection
include 'conn.php';

// Fetch all products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
        .product-item {
            margin-bottom: 30px;
        }
        .product-item img {
            max-width: 100%;
            height: auto;
        }
        .product-item h4 {
            margin: 10px 0;
        }
        .product-item p {
            margin: 0;
        }
    </style>
</head>
<body>

<?php include 'Navbar.php'; ?>

<div class="container">
    <h1 class="my-4">Product List</h1>
    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 product-item">
                    <div class="card">
                        <img src="images/<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h4>
                            <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                            <p class="card-text"><strong>Price:</strong> $<?php echo number_format($row['price'], 2); ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'Footer.php'; ?>

<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
