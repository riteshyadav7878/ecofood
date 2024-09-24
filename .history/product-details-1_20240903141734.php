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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Product Details Page">
    <title><?php echo htmlspecialchars($product['title']); ?> - Product Details</title>
    
    <!-- CSS links -->
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    
    <style>
        /* Include your custom CSS here */
        .product-section {
            background-color: #f8f9fa;
            padding: 30px 0;
        }
        .product-container {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
        }
        .product-image-container {
            position: relative;
            background-color: #ffffff;
            border: 2px solid #6c757d;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 100%;
        }
        .product-image-container img {
            width: 100%;
            display: block;
            border-radius: 5px;
        }
        .zoomed-image {
            position: absolute;
            top: 0;
            left: 100%;
            width: 200%;
            height: auto;
            border: 1px solid #ddd;
            background: #fff;
            transform: scale(0);
            transition: transform 0.5s ease;
            cursor: none;
            z-index: 10;
        }
        .product-image-container:hover .zoomed-image {
            transform: scale(1);
        }
        .product-image-container:hover {
            overflow: hidden;
        }
        .product-details {
            background-color: #ffffff;
            border: 2px solid #6c757d;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 100%;
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
            margin: 0 5px;
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
        .btn-secondary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-secondary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .review-section {
            margin-top: 30px;
        }
        .review-section h3 {
            margin-bottom: 20px;
            color: #343a40;
        }
        .review {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .review p {
            margin: 0;
        }
        .review-form {
            margin-top: 30px;
        }
        .review-form textarea {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            resize: vertical;
        }
        .review-form button {
            background-color: #ff6600;
            border: none;
            color: white;
            padding: 10px 20px;
            cursor: pointer;
        }
        .review-form button:hover {
            background-color: #e65c00;
        }
    </style>
</head>
<body>

<!-- Page Header -->
<header>
    <div class="section dark-background">
        <div class="container">
            <div class="header-2">
                <div class="header-left">
                    <p>
                        <i class="fa fa-map-marker"></i>256 Address Name, New York City
                        <span>|</span>
                        <i class="fa fa-clock-o"></i>07:30 AM - 11:00 PM
                    </p>
                </div>
                <div class="header-right">
                    <div class="header-login">
                        <a href="login.php">
                            <i class="fa fa-user"></i>Log in
                        </a>
                        <span>/</span>
                        <a href="register.php">Register</a>
                    </div>
                    <span class="divider">|</span>
                    <div class="header-search">
                        <button class="fa fa-search"></button>
                        <div class="search-box">
                            <input type="text" placeholder="Search..." />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Navigation -->
<?php include 'Navbar.php'; ?>

<!-- Product Details Section -->
<section>
    <div class="section primary-color-background">
        <div class="container">
            <div class="p-t-70 p-b-85">
                <div class="heading-page-1">
                    <h3>Product Details</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="section border-bottom-grey">
        <div class="container">
            <div class="breadcrumb-1">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="shop-list-with-sidebar.php">Product Details</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Product Details -->
<section class="product-section">
    <div class="container">
        <div class="row product-container">
            <div class="col-md-6 col-lg-5 product-image-container">
                <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="img-fluid" id="main-image" />
                <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="zoomed-image" id="zoomed-image" />
            </div>
            <div class="col-md-6 col-lg-7 product-details">
                <h1><?php echo htmlspecialchars($product['title']); ?></h1>
                <p><strong>Price:</strong> $<?php echo htmlspecialchars($product['price']); ?></p>
                <p><strong>Description:</strong></p>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p><strong>Status:</strong> <?php echo ucfirst(htmlspecialchars($product['status'])); ?></p>

                <div class="quantity-selector">
                    <button id="decrease-quantity" class="btn btn-primary">-</button>
                    <input type="number" id="quantity" value="1" min="1">
                    <button id="increase-quantity" class="btn btn-primary">+</button>
                </div>

                <a href="add_cart.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">Add to Cart</a>
                <button onclick="window.history.back();" class="btn btn-secondary">Close</button>
            </div>
        </div>

        <div class="review-section">
            <h3>Reviews</h3>
            <?php
            // Fetch reviews for the product
            $review_sql = "SELECT * FROM reviews WHERE product_id = $product_id";
            $review_result = mysqli_query($conn, $review_sql);
            while ($review = mysqli_fetch_assoc($review_result)) {
                echo '<div class="review">';
                echo '<p><strong>' . htmlspecialchars($review['reviewer_name']) . ':</strong></p>';
                echo '<p>' . htmlspecialchars($review['review_text']) . '</p>';
                echo '</div>';
            }
            ?>

            <div class="review-form">
                <h3>Submit a Review</h3>
                <form action="submit_review.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <div class="form-group">
                        <label for="reviewer_name">Name:</label>
                        <input type="text" name="reviewer_name" id="reviewer_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="review_text">Review:</label>
                        <textarea name="review_text" id="review_text" rows="5" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Other Products Section -->
<section>
    <div class="section border-bottom-grey">
        <div class="container">
            <div class="heading-page-1">
                <h3>Other Products</h3>
            </div>
            <div class="row">
                <?php
                // Fetch other products
                $other_products_sql = "SELECT * FROM product ORDER BY RAND() LIMIT 4";
                $other_products_result = mysqli_query($conn, $other_products_sql);
                while ($other_product = mysqli_fetch_assoc($other_products_result)) {
                    echo '<div class="col-md-3">';
                    echo '<div class="product-item">';
                    echo '<img src="images/' . htmlspecialchars($other_product['image']) . '" alt="' . htmlspecialchars($other_product['title']) . '" class="img-fluid">';
                    echo '<h4>' . htmlspecialchars($other_product['title']) . '</h4>';
                    echo '<p>$' . htmlspecialchars($other_product['price']) . '</p>';
                    echo '<a href="product-details.php?id=' . $other_product['id'] . '" class="btn btn-primary">View Details</a>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<?php include 'footer.php'; ?>

<!-- JavaScript links -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

<script>
    // JavaScript for zoom effect
    document.getElementById('main-image').addEventListener('mousemove', function(e) {
        var zoomedImage = document.getElementById('zoomed-image');
        var rect = this.getBoundingClientRect();
        var x = e.clientX - rect.left;
        var y = e.clientY - rect.top;
        var xPercent = x / this.offsetWidth * 100;
        var yPercent = y / this.offsetHeight * 100;
        zoomedImage.style.backgroundPosition = `${xPercent}% ${yPercent}%`;
    });
</script>

</body>
</html>
