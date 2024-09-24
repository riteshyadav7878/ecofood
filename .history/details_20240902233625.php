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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }

        .product-container {
            display: flex;
            align-items: flex-start;
            gap: 30px;
            max-width: 900px;
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

        .zoomed-image {
            display: none;
        }

        .product-details {
            max-width: 400px;
            background-color: #f8f9fa;
            border: 2px solid #6c757d;
            border-radius: 10px;
            padding: 15px;
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
    </style>
</head>

<body>
    <header>
        <!-- Your header content here -->
        <?php include 'Navbar.php'; ?>
    </header>

    <section class="product-section">
        <div class="product-container">
            <div class="product-image-container">
                <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="img-fluid" id="main-image" />
                <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="zoomed-image" id="zoomed-image" />
            </div>
            <div class="product-details">
                <h1><?php echo htmlspecialchars($product['title']); ?></h1>
                <p><strong>Price:</strong> $<?php echo htmlspecialchars($product['price']); ?></p>
                <p><strong>Description:</strong></p>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p><strong>Status:</strong> <?php echo ucfirst(htmlspecialchars($product['status'])); ?></p>
                
                <div class="quantity-selector">
                    <button id="decrease-quantity">-</button>
                    <input type="number" id="quantity" value="1" min="1">
                    <button id="increase-quantity">+</button>
                </div>
                
                <a href="add_cart.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">Add to Cart</a>
                <button onclick="window.history.back();" class="btn btn-secondary">Close</button>
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
