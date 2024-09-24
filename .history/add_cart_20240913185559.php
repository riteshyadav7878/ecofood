<?php
session_name("user_session");
// Start the session
session_start();

// Include your database connection file
include 'conn.php';

// Check if a product ID is provided
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // Fetch the product details from the database
    $sql = "SELECT * FROM product WHERE id = $product_id";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        // Initialize the cart session if it doesn't exist
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if the product is already in the cart
        if (isset($_SESSION['cart'][$product_id])) {
            // If product is already in the cart, increase the quantity
            $_SESSION['cart'][$product_id]['quantity']++;
        } else {
            // If product is not in the cart, add it
            $_SESSION['cart'][$product_id] = [
                'title' => $product['title'],
                'price' => $product['price'],
                'quantity' => 1,
                'image' => $product['image']
            ];
        }

        // Redirect to the cart page or display a success message
        header("Location: cart.php");
        exit();
    } else {
        echo "Product not found!";
    }
} else {
    echo "No product ID provided!";
    exit();
}
?>
