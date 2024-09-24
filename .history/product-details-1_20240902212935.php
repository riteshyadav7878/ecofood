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
        .zoom {
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .zoom:hover {
            transform: scale(1.2);
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
                <div class="col-md-6">
                    <!-- Product Image -->
                    <img src="images/<?php echo htmlspecialchars($product['image']); ?>" 
                         alt="<?php echo htmlspecialchars($product['title']); ?>" 
                         class="img-fluid zoom" 
                         data-toggle="modal" 
                         data-target="#imageModal" />
                </div>
                <div class="col-md-6">
                    <!-- Product Details -->
                    <h1><?php echo htmlspecialchars($product['title']); ?></h1>
                    <p><strong>Price:</strong> $<?php echo htmlspecialchars($product['price']); ?></p>
                    <p><strong>Description:</strong></p>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <p><strong>Status:</strong> <?php echo ucfirst(htmlspecialchars($product['status'])); ?></p>
                    
                    <!-- Quantity Selector -->
                    <form action="add_cart.php" method="get">
                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>" />
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" />
                        </div>
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal for Image Zoom -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Product Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="images/<?php echo htmlspecialchars($product['image']); ?>" 
                         alt="<?php echo htmlspecialchars($product['title']); ?>" 
                         class="img-fluid" />
                </div>
            </div>
        </div>
    </div>

    <footer>
        <?php include 'Footer.php'; ?>
    </footer>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>
