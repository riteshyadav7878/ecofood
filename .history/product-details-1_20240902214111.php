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
            width: 100%;
            max-width: 500px;
        }

        .product-image-container img {
            width: 100%;
            display: block;
        }

        .zoomed-image {
            position: absolute;
            top: 0;
            left: 100%;
            width: 300%;
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

        .product-image-container:hover .zoomed-image {
            display: block;
        }

        .zoomed-image {
            display: none;
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
                    <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="img-fluid" id="main-image" />
                    <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="zoomed-image" id="zoomed-image" />
                </div>
                <div class="col-md-6 product-details">
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
        });
    </script>
</body>

</html>
