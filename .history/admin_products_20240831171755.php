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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Product Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Add New Product</h1>
        <form action="process_product.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
