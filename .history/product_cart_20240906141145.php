<?php
// Include your database connection file
include 'conn.php';

// Start the session
?

    // Fetch the product details from the database
    $sql = "SELECT * FROM product WHERE id = $product_id";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        // Initialize cart if not set
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Add or update the product in the cart
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = array(
                'title' => $product['title'],
                'price' => $product['price'],
                'quantity' => $quantity
            );
        }

        // Redirect to the same page to prevent form resubmission
        header('Location: product_cart.php?id=' . $product_id);
        exit;
    } else {
        echo "Product not found!";
        exit;
    }
}

// Fetch the product details if an ID is provided
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

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
    <header>
        <?php include 'Navbar.php'; ?>
    </header>

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

                    <form action="product_cart.php?id=<?php echo $product_id; ?>" method="post">
                        <div class="quantity-selector">
                            <button type="button" id="decrease-quantity" class="btn btn-primary">-</button>
                            <input type="number" id="quantity" name="quantity" value="1" min="1">
                            <button type="button" id="increase-quantity" class="btn btn-primary">+</button>
                        </div>
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                        <button onclick="window.history.back();" type="button" class="btn btn-secondary">Close</button>
                    </form>
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
                    <h4>Write Your Own Review</h4>
                    <form action="submit_review.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <div class="mb-3">
                            <label for="reviewer-name" class="form-label">Your Name</label>
                            <input type="text" id="reviewer-name" name="reviewer_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="review-text" class="form-label">Your Review</label>
                            <textarea id="review-text" name="review_text" rows="4" class="form-control" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <?php include 'Footer.php'; ?>
    </footer>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
        // Zoom effect for product image
        const mainImage = document.getElementById('main-image');
        const zoomedImage = document.getElementById('zoomed-image');
        mainImage.addEventListener('mousemove', function (e) {
            const { offsetX, offsetY } = e;
            const { width, height } = mainImage;
            const xPercent = offsetX / width * 100;
            const yPercent = offsetY / height * 100;
            zoomedImage.style.transform = `translate(-${xPercent}%, -${yPercent}%)`;
        });
        mainImage.addEventListener('mouseleave', function () {
            zoomedImage.style.transform = `scale(0)`;
        });

        // Quantity selector
        document.getElementById('increase-quantity').addEventListener('click', function () {
            const quantityInput = document.getElementById('quantity');
            quantityInput.value = parseInt(quantityInput.value) + 1;
        });
        document.getElementById('decrease-quantity').addEventListener('click', function () {
            const quantityInput = document.getElementById('quantity');
            if (parseInt(quantityInput.value) > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
            }
        });
    </script>
</body>

</html>
