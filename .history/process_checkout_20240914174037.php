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

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];

    // Calculate the total order amount
    $orderTotal = 0;
    foreach ($_SESSION['cart'] as $id => $item) {
        $orderTotal += $item['price'] * $item['quantity'];
    }

    // Insert the order into the cart_order table
    $sql = "INSERT INTO cart_order (user_id, full_name, email, address, city, zip, total) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssd", $_SESSION['user_id'], $fullName, $email, $address, $city, $zip, $orderTotal);

    if ($stmt->execute()) {
        // Get the ID of the newly created order
        $orderId = $stmt->insert_id;

        // Insert each item from the cart into the order_cart table
        foreach ($_SESSION['cart'] as $id => $item) {
            $sql = "INSERT INTO order_cart (order_id, product_id, product_title, price, quantity, total) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $itemTotal = $item['price'] * $item['quantity'];
            $stmt->bind_param("iisidd", $orderId, $id, $item['title'], $item['price'], $item['quantity'], $itemTotal);
            $stmt->execute();
        }

        // Clear the cart session
        unset($_SESSION['cart']);

        // Redirect to a success page
        header("Location: order_success.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
