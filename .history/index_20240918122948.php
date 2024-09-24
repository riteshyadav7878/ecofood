<?php
// Database connection
require_once 'conn.php';

// Query to fetch products
$query = "SELECT * FROM product";
$result_products = mysqli_query($conn, $query);

if (!$result_products) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <div class="row">
            <?php while ($product = mysqli_fetch_assoc($result_products)): ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product-1">
                        <div class="product-image">
                            <div class="image-holder">
                                <img src="<?php echo isset($product['image']) ? htmlspecialchars($product['image']) : 'default-image.jpg'; ?>" alt="<?php echo isset($product['name']) ? htmlspecialchars($product['name']) : 'Product Image'; ?>">
                                <?php if (isset($product['status']) && $product['status']): ?>
                                    <div class="product-status <?php echo htmlspecialchars($product['status']); ?>">
                                        <?php echo htmlspecialchars(ucfirst($product['status'])); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="product-details">
                            <h5 class="product-title">
                                <a href="#"><?php echo isset($product['name']) ? htmlspecialchars($product['name']) : 'Product Name'; ?></a>
                            </h5>
                            <p class="product-price">
                                ₹<?php echo isset($product['price']) ? number_format($product['price'], 2) : '0.00'; ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <!-- Include your JavaScript file -->
    <script src="script.js"></script>
</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>
