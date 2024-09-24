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
    <style>
        .product-image-container {
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        .product-image-container img {
            transition: transform 0.5s ease;
        }

        .product-image-container:hover img {
            transform: scale(1.2);
        }

        .zoomed-image {
            position: absolute;
            top: 0;
            right: -50%;
            width: 200%;
            height: auto;
            border: 1px solid #ddd;
            background: #fff;
            display: none;
            z-index: 10;
        }

        .product-image-container:hover .zoomed-image {
            display: block;
        }

        .product-details {
            margin-top: 30px;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }

        .quantity-selector input {
            width: 60px;
            text-align: center;
            border: 1px solid #ddd;
            padding: 5px;
        }

        .quantity-selector button {
            background-color: #ff6600;
            border: none;
            color: white;
            padding: 5px 10px;
            cursor: pointer;
        }

        .quantity-selector button:hover {
            background-color: #e65c00;
        }

        .btn-primary {
            background-color: #ff6600;
            border-color: #ff6600;
        }

        .btn-primary:hover {
            background-color: #e65c00;
            border-color: #e65c00;
        }
    </style>
</head>

<body>
    <header>
        <!-- Your header content here -->
        <?php include 'Navbar.php'; ?>
    </header>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-6 product-image-container">
                    <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="img-fluid" />
                    <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="zoomed-image" />
                </div>
                <div class="col-md-6 product-details">
                    <h1><?php echo htmlspecialchars($product['title']); ?></h1>
                    <p><strong>Price:</strong> $<?php echo htmlspecialchars($product['price']); ?></p>
                    <p><strong>Description:</strong></p>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <p><strong>Status:</strong> <?php echo ucfirst(htmlspecialchars($product['status'])); ?></p>
                    
                    <div class="quantity-selector">
                        <button>-</button>
                        <input type="number" value="1" min="1">
                        <button>+</button>
                    </div>
                    
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
