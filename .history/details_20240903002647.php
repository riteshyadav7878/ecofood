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
                    <h4>Write Your Own Review</h4>
                    <form action="submit_review.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <div class="mb-3">
                            <label for="reviewer-name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="reviewer-name" name="reviewer_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="review-text" class="form-label">Your Review</label>
                            <textarea class="form-control" id="review-text" name="review_text" rows="4" required></textarea>
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
        $(document).ready(function () {
            const mainImage = $('#main-image');
            const zoomedImage = $('#zoomed-image');

            mainImage.on('mousemove', function (e) {
                const offset = mainImage.offset();
                const x = e.pageX - offset.left;
                const y = e.pageY - offset.top;
                const xPercent = (x / mainImage.width()) * 100;
                const yPercent = (y / mainImage.height()) * 100;

                zoomedImage.css('transform-origin', `${xPercent}% ${yPercent}%`);
                zoomedImage.css('background-image', `url('${mainImage.attr('src')}')`);
                zoomedImage.css('display', 'block');
            });

            mainImage.on('mouseleave', function () {
                zoomedImage.css('display', 'none');
            });

            // Quantity selector functionality
            $('#increase-quantity').click(function () {
                const quantityInput = $('#quantity');
                quantityInput.val(parseInt(quantityInput.val()) + 1);
            });

            $('#decrease-quantity').click(function () {
                const quantityInput = $('#quantity');
                const currentValue = parseInt(quantityInput.val());
                if (currentValue > 1) {
                    quantityInput.val(currentValue - 1);
                }
            });
        });
    </script>
</body>

</html>
