<?php
session_start();
include 'conn.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if fields are set
    if (isset($_POST['name']) && isset($_POST['price']) && isset($_FILES['image'])) {
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
    } else {
        echo '<div class="alert alert-danger mt-3" role="alert">Form data missing.</div>';
    }
} else {
    echo '<div class="alert alert-danger mt-3" role="alert">Invalid request method.</div>';
}

$conn->close();
?>
