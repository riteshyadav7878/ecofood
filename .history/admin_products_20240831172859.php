<?php
// admin_product.php

// Connect to your database (replace with your actual database connection code)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];

    // Update product details in the database
    $sql = "UPDATE products SET title='$title', price='$price', image='$image' WHERE id=$productId";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // Handle file upload
    if (!empty($image)) {
        move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $image);
    }
}

// Fetch product details
$productId = isset($_GET['id']) ? intval($_GET['id']) : 1; // default to 1 if no id is provided
$sql = "SELECT * FROM products WHERE id=$productId";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Product Page</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Edit Product</h1>
    <form action="admin_product.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

        <div class="form-group">
            <label for="title">Product Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo $product['title']; ?>" required>
        </div>

        <div class="form-group">
            <label for="price">Product Price</label>
            <input type="text" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>" required>
        </div>

        <div class="form-group">
            <label for="image">Product Image</label>
            <input type="file" class="form-control-file" id="image" name="image">
            <img src="images/<?php echo $product['image']; ?>" alt="Product Image" width="100">
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>

<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
