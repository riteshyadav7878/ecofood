<?php
// Start the session
session_start();

// Include your database connection file
include 'conn.php';

// Fetch all products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Handle adding to cart
if (isset($_POST['add_to_cart'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    // Fetch product details
    $product_sql = "SELECT * FROM products WHERE id = $product_id";
    $product_result = $conn->query($product_sql);
    $product = $product_result->fetch_assoc();

    if ($product) {
        $item = array(
            'id' => $product['id'],
            'title' => $product['title'],
            'price' => $product['price'],
            'quantity' => $quantity
        );

        // Check if the product is already in the cart
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $item;
        }
    }
}

// Check if the cart session exists and is not empty
$cart_empty = !isset($_SESSION['cart']) || empty($_SESSION['cart']);
$total = 0;
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product List & Checkout</title>
    <meta name="description" content="Ecofood theme template">
    <meta name="author" content="AuCreative">
    <meta name="keywords" content="Ecofood theme template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS Links -->
    <link href="fonts/fonts.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/colors/green.css" rel="stylesheet" id="colors">

    <style>
        body {
            background: linear-gradient(to right, #ffecd2, #fcb69f);
        }
        .product-container, .checkout-container {
            background: #fff4e6;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        .product-card, .checkout-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        .product-card img, .checkout-card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .product-card h3, .checkout-card h3 {
            font-size: 1.25rem;
            margin: 10px 0;
        }
        .product-card p, .checkout-card p {
            font-size: 1rem;
        }
        .btn-primary {
            background-color: #ff7f50;
            border-color: #ff7f50;
        }
        .btn-primary:hover {
            background-color: #ff6347;
            border-color: #ff6347;
        }
    </style>
</head>
<body>

<?php include 'Unavbar.php'; ?>

<section>
    <div class="section primary-color-background">
        <div class="container">
            <div class="p-t-70 p-b-85">
                <div class="heading-page-1">
                    <h3>Product List & Checkout</h3>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="product-container">
        <h3>Products</h3>
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-12 col-md-4">
                        <div class="product-card">
                            <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                            <p>Price: $<?php echo htmlspecialchars($row['price']); ?></p>
                            <p>Description: <?php echo htmlspecialchars($row['description']); ?></p>
                            <form method="POST" action="">
                                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                <input type="number" name="quantity" value="1" min="1" required>
                                <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center">No products found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!$cart_empty): ?>
        <div class="checkout-container">
            <h3>Checkout</h3>
            <div class="row">
                <!-- Order Summary -->
                <div class="col-12 col-md-6">
                    <h3>Order Summary</h3>
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['title']); ?></td>
                                    <td>$<?php echo htmlspecialchars($item['price']); ?></td>
                                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                    <td>$<?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                                    <?php $total += $item['price'] * $item['quantity']; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right font-weight-bold">Total</td>
                                <td class="font-weight-bold">$<?php echo $total; ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Billing Details -->
                <div class="col-12 col-md-6">
                    <h3>Billing Details</h3>
                    <form action="process_checkout.php" method="POST">
                        <div class="form-group">
                            <label for="fullName">Full Name</label>
                            <input type="text" class="form-control" id="fullName" name="fullName" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                        <div class="form-group">
                            <label for="zip">Zip Code</label>
                            <input type="text" class="form-control" id="zip" name="zip" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'Footer.php'; ?>

<!-- JavaScript Files -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
