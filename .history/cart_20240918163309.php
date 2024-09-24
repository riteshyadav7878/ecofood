<?php
session_name("user_session");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include your database connection file
include 'conn.php';

// Function to load cart from database
function load_cart_from_db($user_id, $conn) {
    $query = "SELECT product.id, product.title, product.image, product.price, user_cart.quantity 
              FROM user_cart
              JOIN product ON user_cart.product_id = product.id
              WHERE user_cart.user_id = $user_id";
    $result = mysqli_query($conn, $query);
    
    // Initialize the cart in session
    $_SESSION['cart'] = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['cart'][$row['id']] = [
            'title' => $row['title'],
            'image' => $row['image'],
            'price' => $row['price'],
            'quantity' => $row['quantity']
        ];
    }
}

// Function to update the cart in the database
function update_cart_in_db($user_id, $cart_items, $conn) {
    foreach ($cart_items as $product_id => $item) {
        $quantity = intval($item['quantity']);
        
        // Check if the item already exists in the cart
        $query = "SELECT id FROM user_cart WHERE user_id = $user_id AND product_id = $product_id";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) > 0) {
            // Update the quantity if the item exists
            $query = "UPDATE user_cart SET quantity = $quantity WHERE user_id = $user_id AND product_id = $product_id";
        } else {
            // Insert a new record for the item
            $query = "INSERT INTO user_cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)";
        }
        mysqli_query($conn, $query);
    }
}

// Check if the logged-in user's account has been deleted
if (isset($_SESSION['user_id'])) {
    $user_id = intval($_SESSION['user_id']);
    $sql = "SELECT id FROM user WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) {
        // User's account has been deleted, destroy session and redirect
        session_destroy();
        header("Location: login.php");
        exit();
    }
}

// Handle updating the quantity
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $id => $quantity) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] = max(1, intval($quantity)); // Ensure quantity is at least 1
        }
    }

    // Save cart to the database
    update_cart_in_db($_SESSION['user_id'], $_SESSION['cart'], $conn);

    // Redirect to avoid resubmission issues
    header('Location: cart.php');
    exit();
}

// Handle removal of an item from the cart
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Remove the item from the cart if it exists
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);

        // If the cart is empty after removal, destroy the cart session
        if (empty($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }

        // Update the cart in the database
        update_cart_in_db($_SESSION['user_id'], $_SESSION['cart'], $conn);
    }

    // Redirect to avoid resubmission issues
    header('Location: cart.php');
    exit();
}

// Load cart from the database when the user logs in
if (!isset($_SESSION['cart'])) {
    load_cart_from_db($_SESSION['user_id'], $conn);
}

$total = 0;
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <style>
        .table img {
            width: 100px;
        }
        .table td {
            vertical-align: middle;
        }
        .table td img {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .table td.quantity-col {
            width: 10%;
        }
        .table td.action-col {
            width: 20%;
        }
        @media (max-width: 768px) {
            .table td {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <header>
        <?php include 'Unavbar.php'; ?>
    </header>

    <section>
        <div class="section primary-color-background">
            <div class="container">
                <div class="p-t-70 p-b-85">
                    <div class="heading-page-1">
                        <h3>Your Cart</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container mt-5">
            <?php if (empty($_SESSION['cart'])): ?>
                <div class="alert alert-warning text-center" role="alert">
                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                    <strong>No record found!</strong> Your cart is empty.
                </div>
                <div class="text-center mt-4">
                    <a href="shop-list-without-sidebar.php" class="btn btn-primary btn-sm">
                        <i class="fa fa-shopping-cart"></i> Continue Shopping
                    </a>
                </div>
            <?php else: ?>
                <form method="post" action="">
                    <table class="table table-bordered table-responsive">
                        <thead class="thead-dark">
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th class="quantity-col">Quantity</th>
                                <th>Total</th>
                                <th class="action-col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                                <tr>
                                    <td class="text-center">
                                        <img src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                                    </td>
                                    <td><?php echo htmlspecialchars($item['title']); ?></td>
                                    <td>₹<?php echo htmlspecialchars($item['price']); ?></td>
                                    <td class="quantity-col">
                                        <input type="number" name="quantity[<?php echo $id; ?>]" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1" class="form-control form-control-sm">
                                    </td>
                                    <td>₹<?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                                    <td class="action-col">
                                        <a href="?action=remove&id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Remove</a>
                                        <button type="submit" name="update_cart" class="btn btn-warning btn-sm mt-2">Update Quantity</button>
                                    </td>
                                    <?php $total += $item['price'] * $item['quantity']; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" style="font-weight: bold" class="text-right font-weight-bold">Total</td>
                                <td colspan="2" style="font-weight: bold">₹<?php echo $total; ?></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="text-center mt-4">
