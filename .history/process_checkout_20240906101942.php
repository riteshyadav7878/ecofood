<?php
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

    // Save order to database (this is a basic example, adapt to your schema)
    $orderTotal = 0;
    foreach ($_SESSION['cart'] as $id => $item) {
        $orderTotal += $item['price'] * $item['quantity'];
    }

    $sql = "INSERT INTO orders (username, fullName, email, address, city, zip, total) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssd", $_SESSION['username'], $fullName, $email, $address, $city, $zip, $orderTotal);

    if ($stmt->execute()) {
        // If the order is saved successfully, you can now insert order items
        $orderId = $stmt->insert_id;

        foreach ($_SESSION['cart'] as $id => $item) {
            $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiid", $orderId, $id, $item['quantity'], $item['price']);
            $stmt->execute();
        }

        // Clear the cart session
        unset($_SESSION['cart']);

        // Redirect to a success page
        header("Location: order_success.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
