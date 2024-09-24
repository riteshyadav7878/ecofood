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
    <meta name="description" content="Ecofood theme tempalte">
    <meta name="author" content="AuCreative">
    <meta name="keywords" content="Ecofood theme template">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="fonts/fonts.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/css-hamburgers/dist/hamburgers.min.css" rel="stylesheet">
    <link href="vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css" rel="stylesheet">
    <link href="vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="vendor/revolution/css/layers.css" rel="stylesheet">
    <link href="vendor/revolution/css/navigation.css" rel="stylesheet">
    <link href="vendor/revolution/css/settings.css" rel="stylesheet">
    <link href="vendor/owl.carousel/dist/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/switcher.css" rel="stylesheet">
    <link href="css/colors/green.css" rel="stylesheet" id="colors">
    <link href="css/retina.css" rel="stylesheet">

    <link rel="shortcut icon" href="favicon.png">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.html">
    <script src="js/modernizr-custom.js"></script>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .table th, .table td {
        text-align: center;
        vertical-align: middle;
        width: 16%; /* Adjust width as needed to fit all columns */
    }

    .table th:nth-child(1),
    .table td:nth-child(1) {
        width: 8%;
    }

    .table th:nth-child(2),
    .table td:nth-child(2) {
        width: 16%;
    }

    .table th:nth-child(3),
    .table td:nth-child(3) {
        width: 16%;
    }

    .table th:nth-child(4),
    .table td:nth-child(4) {
        width: 24%;
    }

    .table th:nth-child(5),
    .table td:nth-child(5) {
        width: 20%;
    }

    .table th:nth-child(6),
    .table td:nth-child(6) {
        width: 20%;
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
     <!-- Products List -->
<div class="mb-4">
    <h4 class="text-center">Product List</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Price</th>
                <th>Description</th> <!-- Add Description Column -->
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
                    <td><?php echo $row['description']; ?></td> <!-- Add Description Data -->
                    <td>
                        <div class="product-image" data-toggle="modal" data-target="#productModal"
                            data-title="<?php echo $row['title']; ?>"
                            data-price="<?php echo $row['price']; ?>"
                            data-image="images/<?php echo $row['image']; ?>"
                            data-description="<?php echo $row['description']; ?>"
                            data-id="<?php echo $row['id']; ?>">
                            <img src="images/<?php echo $row['image']; ?>" alt="Product Image" width="100">
                            <?php if (!empty($row['status'])): ?>
                                <div class="product-status <?php echo $row['status']; ?>">
                                    <span><?php echo strtoupper($row['status']); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <!-- Edit and Delete Actions -->
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?php echo $row['id']; ?>">Edit</button>
                        <form action="" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm" name="delete_product">Delete</button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Product Modal -->
                <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <div class="form-group">
                                        <label for="edit_title">Title</label>
                                        <input type="text" class="form-control" id="edit_title" name="title" value="<?php echo $row['title']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_price">Price</label>
                                        <input type="text" class="form-control" id="edit_price" name="price" value="<?php echo $row['price']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_status">Status</label>
                                        <select class="form-control" id="edit_status" name="status">
                                            <option value="">None</option>
                                            <option value="hot" <?php if ($row['status'] == 'hot') echo 'selected'; ?>>HOT</option>
                                            <option value="sale" <?php if ($row['status'] == 'sale') echo 'selected'; ?>>SALE</option>
                                            <option value="new" <?php if ($row['status'] == 'new') echo 'selected'; ?>>NEW</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_description">Description</label>
                                        <textarea class="form-control" id="edit_description" name="description" rows="3" required><?php echo $row['description']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_image">Image</label>
                                        <input type="file" class="form-control" id="edit_image" name="image">
                                        <small class="form-text text-muted">Leave blank if you don't want to change the image.</small>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="update_product">Update Product</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </tbody>
    </table>
</div>

    </div>

    <!-- Product Details Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Product Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 id="product_title"></h5>
                    <p id="product_price"></p>
                    <img id="product_image" src="" alt="Product Image" class="img-fluid">
                    <p id="product_description"></p>
                </div>
            </div>
        </div>
    </div>

    <?php include 'admin_Footer.php'; ?>
    
    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $('#productModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var title = button.data('title');
            var price = button.data('price');
            var image = button.data('image');
            var description = button.data('description');

            var modal = $(this);
            modal.find('#product_title').text(title);
            modal.find('#product_price').text(price);
            modal.find('#product_image').attr('src', image);
            modal.find('#product_description').text(description);
        });
    </script>
</body>
</html>
