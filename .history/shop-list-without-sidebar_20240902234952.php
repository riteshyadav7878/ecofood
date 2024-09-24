<?php
// Include your database connection file
include 'conn.php';

// Fetch all products from the database
$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Error fetching products: " . mysqli_error($conn);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Shop - Product List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
        .product-list {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
        }

        .product-item {
            width: 250px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .product-item:hover {
            transform: scale(1.05);
        }

        .product-item img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .product-title {
            font-size: 18px;
            margin-top: 10px;
        }

        .product-price {
            font-size: 16px;
            color: #ff6600;
            margin-top: 5px;
        }

        .btn-view-details {
            margin-top: 10px;
            background-color: #ff6600;
            border-color: #ff6600;
        }

        .btn-view-details:hover {
            background-color: #e65c00;
            border-color: #e65c00;
        }
    </style>
</head>

<body>
    <header>
        <?php include 'Navbar.php'; ?>
    </header>

    <section class="container mt-5">
        <h1 class="text-center">Product List</h1>
        <div class="product-list">
            <?php while ($product = mysqli_fetch_assoc($result)) { ?>
                <div class="product-item">
                    <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" />
                    <h2 class="product-title"><?php echo htmlspecialchars($product['title']); ?></h2>
                    <p class="product-price">$<?php echo htmlspecialchars($product['price']); ?></p>
                    <a href="product-details-1.php?id=<?php echo $product['id']; ?>" class="btn btn-view-details btn-sm">View Details</a>
                </div>
            <?php } ?>
        </div>
    </section>

    <footer>
        <?php include 'Footer.php'; ?>
    </footer>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>
