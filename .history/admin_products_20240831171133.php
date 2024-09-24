
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php"); // Redirect to login page
    exit();
}<?php
// admin_product.php

// Include database connection
include 'db_connect.php'; // Change to your actual database connection file

// Handle form submissions for adding or updating products
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        // Add product logic
        $name = $_POST['product_name'];
        $price = $_POST['product_price'];
        $image = $_FILES['product_image']['name'];
        $target = "images/" . basename($image);

        // Save the image
        move_uploaded_file($_FILES['product_image']['tmp_name'], $target);

        // Insert into database
        $sql = "INSERT INTO products (name, price, image) VALUES ('$name', '$price', '$image')";
        mysqli_query($conn, $sql);
    } elseif (isset($_POST['update_product'])) {
        // Update product logic
        $id = $_POST['product_id'];
        $name = $_POST['product_name'];
        $price = $_POST['product_price'];
        $image = $_FILES['product_image']['name'];
        if ($image) {
            $target = "images/" . basename($image);
            move_uploaded_file($_FILES['product_image']['tmp_name'], $target);
            $sql = "UPDATE products SET name='$name', price='$price', image='$image' WHERE id='$id'";
        } else {
            $sql = "UPDATE products SET name='$name', price='$price' WHERE id='$id'";
        }
        mysqli_query($conn, $sql);
    } elseif (isset($_POST['delete_product'])) {
        // Delete product logic
        $id = $_POST['product_id'];
        $sql = "DELETE FROM products WHERE id='$id'";
        mysqli_query($conn, $sql);
    }
}

// Fetch products
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Product Management</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1>Product Management</h1>

    <!-- Form to Add New Product -->
    <form action="admin_product.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="product_name" name="product_name" required>
        </div>
        <div class="mb-3">
            <label for="product_price" class="form-label">Price</label>
            <input type="text" class="form-control" id="product_price" name="product_price" required>
        </div>
        <div class="mb-3">
            <label for="product_image" class="form-label">Image</label>
            <input type="file" class="form-control" id="product_image" name="product_image">
        </div>
        <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
    </form>

    <!-- Display Products -->
    <h2 class="mt-5">Existing Products</h2>
    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card">
                <img src="images/<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['name']; ?></h5>
                    <p class="card-text">$<?php echo $row['price']; ?></p>

                    <!-- Edit and Delete Buttons -->
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">Edit</button>
                    <form action="admin_product.php" method="POST" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete_product" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>

            <!-- Edit Product Modal -->
            <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="admin_product.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                <div class="mb-3">
                                    <label for="product_name_edit" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" id="product_name_edit" name="product_name" value="<?php echo $row['name']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="product_price_edit" class="form-label">Price</label>
                                    <input type="text" class="form-control" id="product_price_edit" name="product_price" value="<?php echo $row['price']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="product_image_edit" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="product_image_edit" name="product_image">
                                    <small>Current image: <img src="images/<?php echo $row['image']; ?>" width="100"></small>
                                </div>
                                <button type="submit" name="update_product" class="btn btn-primary">Update Product</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>
</html>
