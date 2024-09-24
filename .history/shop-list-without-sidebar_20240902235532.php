<?php
// Include your database connection file
include 'conn.php';

// Start the session
session_start();

// Fetch all products from the database
$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Check if a product ID is provided for detailed view
$selected_product = null;
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    
    // Fetch the selected product details from the database
    $detail_sql = "SELECT * FROM product WHERE id = $product_id";
    $detail_result = mysqli_query($conn, $detail_sql);
    $selected_product = mysqli_fetch_assoc($detail_result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shop - Product List and Details</title>
    <meta name="description" content="Browse our products and view details.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
        .product-list-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
        }
        
        .product-card {
            position: relative;
            width: 100%;
            max-width: 300px;
            background-color: #f8f9fa;
            border: 2px solid #6c757d;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
        }
        
        .product-card img {
            width: 100%;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        
        .product-status {
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .badge-status {
            padding: 5px 10px;
            font-size: 14px;
            color: white;
            border-radius: 5px;
        }

        .badge-status.new {
            background-color: #28a745;
        }

        .badge-status.hot {
            background-color: #dc3545;
        }

        .badge-status.sale {
            background-color: #ffc107;
        }

        .badge-status.none {
            background-color: #6c757d;
        }

        .product-details-section {
            margin-top: 50px;
        }

        .product-image-container {
            position: relative;
            max-width: 400px;
            background-color: #f8f9fa;
            border: 2px solid #6c757d;
            border-radius: 10px;
            padding: 15px;
        }

        .product-image-container img {
            width: 100%;
            display: block;
            border-radius: 5px;
        }

        .product-details {
            max-width: 400px;
            background-color: #f8f9fa;
            border: 2px solid #6c757d;
            border-radius: 10px;
            padding: 15px;
            margin-left: 30px;
        }

        .review-section {
            margin-top: 20px;
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
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
        }

        .review-section {
            margin-top: 30px;
        }

        .review-form {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <header>
        <?php include 'Navbar.php'; ?>
    </header>

    <section class="product-list-container">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <div class="product-status">
                    <?php
                    $status = htmlspecialchars($product['status']);
                    if (in_array($status, ['new', 'hot', 'sale', 'none'])) {
                        echo '<span class="badge badge-status ' . $status . '">' . ucfirst($status) . '</span>';
                    }
                    ?>
                </div>
                <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>">
                <h3><?php echo htmlspecialchars($product['title']); ?></h3>
                <p>$<?php echo htmlspecialchars($product['price']); ?></p>
                <a href="?id=<?php echo $product['id']; ?>" class="btn btn-primary">View Details</a>
            </div>
        <?php endforeach; ?>
    </section>

    <?php if ($selected_product): ?>
        <section class="product-details-section">
            <div class="product-container d-flex justify-content-center">
                <div class="product-image-container">
                    <img src="images/<?php echo htmlspecialchars($selected_product['image']); ?>" alt="<?php echo htmlspecialchars($selected_product['title']); ?>" class="img-fluid" id="main-image" />
                </div>
                <div class="product-details">
                    <h1><?php echo htmlspecialchars($selected_product['title']); ?></h1>
                    <p><strong>Price:</strong> $<?php echo htmlspecialchars($selected_product['price']); ?></p>
                    <p><strong>Description:</strong></p>
                    <p><?php echo htmlspecialchars($selected_product['description']); ?></p>
                    <p><strong>Status:</strong> <?php echo ucfirst(htmlspecialchars($selected_product['status'])); ?></p>
                    
                    <div class="quantity-selector">
                        <button id="decrease-quantity">-</button>
                        <input type="number" id="quantity" value="1" min="1">
                        <button id="increase-quantity">+</button>
                    </div>
                    
                    <a href="add_cart.php?id=<?php echo $selected_product['id']; ?>" class="btn btn-primary">Add to Cart</a>
                    <button onclick="window.history.back();" class="btn btn-secondary">Close</button>
                </div>
            </div>
            
            <!-- Reviews Section -->
            <div class="review-section">
                <h3>Customer Reviews</h3>
                <div class="reviews">
                    <!-- Display reviews from the database here -->
                    <!-- For demonstration, static reviews are shown -->
                    <p><strong>John Doe:</strong> Great product! Highly recommended.</p>
                    <p><strong>Jane Smith:</strong> Satisfied with the quality.</p>
                </div>
                <hr>
                <h4>Write Your Own Review</h4>
                <form class="review-form">
                    <div class="form-group">
                        <textarea class="form-control" rows="3" placeholder="Write your review here..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </form>
            </div>
        </section>
    <?php endif; ?>

    <footer>
        <?php include 'Footer.php'; ?>
    </footer>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
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
