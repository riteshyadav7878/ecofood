<?php
// Include your database connection file
include 'conn.php';

// Start the session
session_start();

// Check if a product ID is provided
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // Fetch the product details from the database
    $sql = "SELECT * FROM product WHERE id = $product_id";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);

    if (!$product) {
        echo "Product not found!";
        exit;
    }
} else {
    echo "No product ID provided!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['title']); ?> - Product Details</title>
    <meta name="description" content="<?php echo htmlspecialchars($product['description']); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
</head>

<body>
    <header>
        <!-- Your header content here -->
        <?php include 'Navbar.php'; ?>
    </header>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="img-fluid" />
                </div>
                <div class="col-md-6">
                    <h1><?php echo htmlspecialchars($product['title']); ?></h1>
                    <p><strong>Price:</strong> $<?php echo htmlspecialchars($product['price']); ?></p>
                    <p><strong>Description:</strong></p>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <p><strong>Status:</strong> <?php echo ucfirst(htmlspecialchars($product['status'])); ?></p>
                    <a href="add_cart.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">Add to Cart</a>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <?php include 'Footer.php'; ?>
    </footer>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>
