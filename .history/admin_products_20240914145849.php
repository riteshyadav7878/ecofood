<?php
session_start(); // Start the session

// Include database connection
include('conn.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php"); // Redirect to login page if not logged in
    exit();
}

// Handle form submissions for adding, updating, and deleting products
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_product'])) {
        $title = $_POST['title'];
        $price = $_POST['price'];
        $status = $_POST['status'];
        $description = $_POST['description']; // Get description
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];

        // Check if image is uploaded
        if (!empty($image)) {
            move_uploaded_file($image_tmp, "images/$image");
        }

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO product (title, price, image, status, description) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $title, $price, $image, $status, $description);
        
        if ($stmt->execute()) {
            $success_message = "Product added successfully.";
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    if (isset($_POST['update_product'])) {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $price = $_POST['price'];
        $status = $_POST['status'];
        $description = $_POST['description']; // Get description
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];

        if (!empty($image)) {
            move_uploaded_file($image_tmp, "images/$image");
            $stmt = $conn->prepare("UPDATE product SET title=?, price=?, image=?, status=?, description=? WHERE id=?");
            $stmt->bind_param("sssssi", $title, $price, $image, $status, $description, $id);
        } else {
            $stmt = $conn->prepare("UPDATE product SET title=?, price=?, status=?, description=? WHERE id=?");
            $stmt->bind_param("ssssi", $title, $price, $status, $description, $id);
        }

        if ($stmt->execute()) {
            $success_message = "Product updated successfully.";
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    if (isset($_POST['delete_product'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM product WHERE id=?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $success_message = "Product deleted successfully.";
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch all products from the database
$sql = "SELECT * FROM product";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
    <meta name="description" content="Manage products in the admin panel">
    <meta name="author" content="Your Name">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS Links -->
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
        .product-status {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 5px;
            color: #fff;
            font-weight: bold;
            border-radius: 3px;
        }

        .product-status.hot {
            background: #ff5722;
        }

        .product-status.sale {
            background: #f44336;
        }

        .product-status.new {
            background: #4caf50;
        }

        .product-image {
            position: relative;
            cursor: pointer; /* Show pointer cursor */
        }

        table {
            font-size: 0.875rem; /* Smaller font size */
        }
        table th, table td {
            padding: 0.5rem; /* Reduced padding */
        }
        .description-cell {
            max-width: 200px; /* Limit description width */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <?php include 'admin_Navbar.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center">Manage Products</h2>
        <?php if (isset($success_message)) { ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php } ?>
        <?php if (isset($error_message)) { ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php } ?>

        <!-- Add Product Form -->
        <div class="mb-4">
            <h4>Add New Product</h4>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" id="price" name="price" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="">None</option>
                        <option value="hot">HOT</option>
                        <option value="sale">SALE</option>
                        <option value="new">NEW</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control" id="image" name="image" required>
                </div>
                <button type="submit" class="btn btn-primary" name="add_product">Add Product</button>
            </form>
        </div>

        <!-- Products List -->
        <div class="mb-4">
            <h4 class="text-center">Product List</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td class="description-cell"><?php echo $row['description']; ?></td>
                            <td>
                                <div class="product-image">
                                    <img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>" style="width: 100px; height: 100px;">
                                    <?php if ($row['status']) { ?>
                                        <div class="product-status <?php echo $row['status']; ?>"><?php echo strtoupper($row['status']); ?></div>
                                    <?php } ?>
                                </div>
                            </td>
                            <td>
                                <!-- Update and Delete Forms -->
                                <form action="" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-warning" name="edit_product">Edit</button>
                                </form>
                                <form action="" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-danger" name="delete_product">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- JavaScript Links -->
    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="vendor/revolution/js/jquery.themepunch.revolution.min.js"></script>
    <script src="vendor/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
