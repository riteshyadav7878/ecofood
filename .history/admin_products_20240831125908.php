<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Product Management</title>
    <link rel="stylesheet" href="path/to/bootstrap.min.css">
    <link rel="stylesheet" href="path/to/your-styles.css">
</head>
<body>
    <div class="container">
        <h1>Admin Product Management</h1>

        <?php
        include 'conn.php'; // Database connection

        // Handle form submission for adding or updating products
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['product_id'];
            $title = $_POST['title'];
            $price = $_POST['price'];
            $status = $_POST['status'];

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $image = $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], "images/$image");
            } else {
                $image = $_POST['current_image']; // Use existing image if no new image is uploaded
            }

            // Insert or update product
            if ($id) {
                $query = "UPDATE products SET title='$title', price='$price', status='$status', image='$image' WHERE id='$id'";
            } else {
                $query = "INSERT INTO products (title, price, status, image) VALUES ('$title', '$price', '$status', '$image')";
            }

            mysqli_query($conn, $query);
            header("Location: admin_product.php"); // Redirect to the same page to avoid form resubmission
            exit();
        }

        // Handle deletion of products
        if (isset($_GET['action']) && $_GET['action'] == 'delete') {
            $id = $_GET['id'];
            $query = "DELETE FROM products WHERE id='$id'";
            mysqli_query($conn, $query);
            header("Location: admin_product.php"); // Redirect to the same page
            exit();
        }

        // Fetch product data if editing
        $editProduct = null;
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query = "SELECT * FROM products WHERE id='$id'";
            $result = mysqli_query($conn, $query);
            $editProduct = mysqli_fetch_assoc($result);
        }
        ?>

        <!-- Add/Edit Product Form -->
        <form action="admin_product.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo $editProduct['id'] ?? ''; ?>">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" name="title" id="title" value="<?php echo $editProduct['title'] ?? ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" class="form-control" name="price" id="price" value="<?php echo $editProduct['price'] ?? ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control" name="image" id="image">
                <?php if (isset($editProduct['image'])) { ?>
                    <img src="images/<?php echo $editProduct['image']; ?>" alt="<?php echo $editProduct['title']; ?>" width="100">
                    <input type="hidden" name="current_image" value="<?php echo $editProduct['image']; ?>">
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" name="status" id="status">
                    <option value="">None</option>
                    <option value="HOT" <?php if (isset($editProduct['status']) && $editProduct['status'] == 'HOT') echo 'selected'; ?>>HOT</option>
                    <option value="SALE" <?php if (isset($editProduct['status']) && $editProduct['status'] == 'SALE') echo 'selected'; ?>>SALE</option>
                    <option value="NEW" <?php if (isset($editProduct['status']) && $editProduct['status'] == 'NEW') echo 'selected'; ?>>NEW</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <!-- Product List -->
        <h2>Product List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM products";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td><img src='images/{$row['image']}' alt='{$row['title']}' width='100'></td>";
                    echo "<td>{$row['title']}</td>";
                    echo "<td>\${$row['price']}</td>";
                    echo "<td>{$row['status']}</td>";
                    echo "<td>
                            <a href='admin_product.php?id={$row['id']}' class='btn btn-warning'>Edit</a>
                            <a href='admin_product.php?action=delete&id={$row['id']}' class='btn btn-danger'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="path/to/bootstrap.bundle.min.js"></script>
</body>
</html>
