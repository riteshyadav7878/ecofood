<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php"); // Redirect to login page
    exit();
}

// Include other necessary files
include 'conn.php';

// Get form data
$name = $_POST['name'];
$price = $_POST['price'];
$image = $_FILES['image'];

// Handle image upload
$imagePath = 'uploads/' . basename($image['name']);
if (move_uploaded_file($image['tmp_name'], $imagePath)) {
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $price, $imagePath);

    // Execute the statement
    if ($stmt->execute()) {
        echo '<div class="alert alert-success mt-3" role="alert">New product added successfully.</div>';
    } else {
        echo '<div class="alert alert-danger mt-3" role="alert">Error: ' . $stmt->error . '</div>';
    }

    $stmt->close();
} else {
    echo '<div class="alert alert-danger mt-3" role="alert">Error uploading image.</div>';
}

$conn->close();
?>
 