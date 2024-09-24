
<?php
// admin_product.php
include('conn.php'); // Connect to your database

// Handle form submissions for add/update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'] ?? null;
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $productImage = $_FILES['product_image']['name'];
    $action = $_POST['action'];

    if ($action == 'Add') {
        // Handle file upload
        move_uploaded_file($_FILES['product_image']['tmp_name'], 'images/' . $productImage);

        // Insert new product into database
        $query = "INSERT INTO products (name, price, image) VALUES ('$productName', '$productPrice', '$productImage')";
        mysqli_query($conn, $query);
    } elseif ($action == 'Update' && $productId) {
        // Handle file upload
        if ($productImage) {
            move_uploaded_file($_FILES['product_image']['tmp_name'], 'images/' . $productImage);
            $imageQuery = ", image='$productImage'";
        } else {
            $imageQuery = "";
        }

        // Update existing product
        $query = "UPDATE products SET name='$productName', price='$productPrice' $imageQuery WHERE id='$productId'";
        mysqli_query($conn, $query);
    } elseif ($action == 'Delete' && $productId) {
        // Delete product
        $query = "DELETE FROM products WHERE id='$productId'";
        mysqli_query($conn, $query);
    }
}

// Fetch products for display
$result = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Product Management</title>
    <link rel="stylesheet" href="path/to/bootstrap.min.css"> <!-- Add Bootstrap CSS -->
</head>
<body>
    <div class="container">
        <h2>Manage Products</h2>

        <!-- Add/Update Product Form -->
        <form action="admin_product.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="product_id" id="product_id">
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name" required>
            </div>
            <div class="form-group">
                <label for="product_price">Price</label>
                <input type="text" class="form-control" id="product_price" name="product_price" required>
            </div>
            <div class="form-group">
                <label for="product_image">Image</label>
                <input type="file" class="form-control" id="product_image" name="product_image">
            </div>
            <button type="submit" class="btn btn-primary" name="action" value="Add">Add Product</button>
            <button type="submit" class="btn btn-primary" name="action" value="Update">Update Product</button>
        </form>

        <!-- Product List -->
        <h3 class="mt-4">Product List</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" width="100"></td>
                        <td>
                            <a href="#" class="btn btn-warning btn-sm edit-btn" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['name']; ?>" data-price="<?php echo $row['price']; ?>" data-image="<?php echo $row['image']; ?>">Edit</a>
                            <a href="admin_product.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        // JavaScript to handle the Edit button click
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('product_id').value = this.getAttribute('data-id');
                document.getElementById('product_name').value = this.getAttribute('data-name');
                document.getElementById('product_price').value = this.getAttribute('data-price');
            });
        });
    </script>
</body>
</html>
