<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Include your database connection
include 'conn.php';

// Check if the cart session exists and is not empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty!";
    exit();
}

// Retrieve and sanitize form data
$fullName = htmlspecialchars($_POST['fullName']);
$email = htmlspecialchars($_POST['email']);
$address = htmlspecialchars($_POST['address']);
$city = htmlspecialchars($_POST['city']);
$zip = htmlspecialchars($_POST['zip']);

// Calculate total from the cart
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}

try {
    // Insert into the cart_order table
    $stmt = $conn->prepare("INSERT INTO cart_order (user_id, full_name, email, address, city, zip, total) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('isssssd', $_SESSION['user_id'], $fullName, $email, $address, $city, $zip, $total);

    if ($stmt->execute()) {
        // Get the last inserted order ID
        $order_id = $conn->insert_id;

        // Insert each item into the order_items table
        $stmt_items = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_title, price, quantity, total) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($_SESSION['cart'] as $id => $item) {
            $item_total = $item['price'] * $item['quantity'];
            $stmt_items->bind_param('iisidd', $order_id, $id, $item['title'], $item['price'], $item['quantity'], $item_total);
            $stmt_items->execute();
        }

        // Clear the cart
        unset($_SESSION['cart']);

        // Redirect to a success page
        header("Location: success.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
} catch (mysqli_sql_exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
