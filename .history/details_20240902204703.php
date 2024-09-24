<?php
// Start the session to manage the cart
session_start();

// Include your database connection file
include 'conn.php';

// Handle adding product to the cart
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Fetch the product details from the database
    $sql = "SELECT * FROM product WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        // Initialize cart in session if not already set
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Check if product is already in the cart
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } else {
            // Add product to cart
            $_SESSION['cart'][$product_id] = array(
                'id' => $product['id'],
                'title' => $product['title'],
                'price' => $product['price'],
                'quantity' => 1
            );
        }

        // Redirect to the same page to show cart contents
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Product not found.";
    }
}

// Fetch all products from the database
$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product List</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-status {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 5px;
            color: #fff;
            font-weight: bold;
            border-radius: 3px;
        }

        .product-status.hot {
            background: #ff5722;
        }

        .product-status.sale {
            background: #f44336;
        }

        .product-status.new {
            background: #4caf50;
        }

        .product-image {
            position: relative;
            cursor: pointer; /* Show pointer cursor */
            display: block;
            margin-bottom: 10px;
        }

        .product-image img {
            width: 100%;
            height: auto;
        }

        .product-details {
            text-align: center;
        }

        .product-title {
            font-size: 1.1em;
            margin: 5px 0;
            font-weight: bold;
        }

        .product-price {
            color: #777;
        }

        .cart-summary {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2>Product List</h2>
    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-4 mb-4">
                <div class="product-image" 
                     data-toggle="modal" 
                     data-target="#productModal"
                     data-title="<?php echo $row['title']; ?>"
                     data-price="<?php echo $row['price']; ?>"
                     data-image="images/<?php echo $row['image']; ?>"
                     data-description="<?php echo $row['description']; ?>"
                     data-id="<?php echo $row['id']; ?>">
                    <img src="images/<?php echo $row['image']; ?>" alt="Product Image">
                    <?php if (!empty($row['status'])): ?>
                        <div class="product-status <?php echo $row['status']; ?>">
                            <span><?php echo strtoupper($row['status']); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- Product Title and Price -->
                <div class="product-details">
                    <!-- Make title clickable -->
                    <div class="product-title">
                        <a href="?product_id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a>
                    </div>
                    <div class="product-price">Price: $<?php echo $row['price']; ?></div>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Cart Summary -->
    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
        <div class="cart-summary">
            <h3>Cart Summary</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Title</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($_SESSION['cart'] as $product) {
                        $productTotal = $product['price'] * $product['quantity'];
                        $total += $productTotal;
                        echo "<tr>
                            <td>{$product['title']}</td>
                            <td>\${$product['price']}</td>
                            <td>{$product['quantity']}</td>
                            <td>\${$productTotal}</td>
                        </tr>";
                    }
                    ?>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Total:</strong></td>
                        <td><strong>$<?php echo number_format($total, 2); ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>

<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
