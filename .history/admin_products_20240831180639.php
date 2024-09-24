<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Products</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/admin.css" rel="stylesheet">
    <script>
        function validateForm() {
            const title = document.getElementById('title').value;
            const price = document.getElementById('price').value;
            const image = document.getElementById('image').files.length;

            // Clear previous error messages
            document.querySelectorAll('.form-error').forEach(el => el.textContent = '');

            let valid = true;

            if (title.trim() === '') {
                document.getElementById('title-error').textContent = 'Title is required.';
                valid = false;
            }
            if (price.trim() === '') {
                document.getElementById('price-error').textContent = 'Price is required.';
                valid = false;
            }
            if (image === 0) {
                document.getElementById('image-error').textContent = 'Image is required.';
                valid = false;
            }

            return valid;
        }

        // Similar function for editing products
        function validateEditForm() {
            const title = document.getElementById('edit_title').value;
            const price = document.getElementById('edit_price').value;
            const image = document.getElementById('edit_image').files.length;

            // Clear previous error messages
            document.querySelectorAll('.form-error').forEach(el => el.textContent = '');

            let valid = true;

            if (title.trim() === '') {
                document.getElementById('edit_title-error').textContent = 'Title is required.';
                valid = false;
            }
            if (price.trim() === '') {
                document.getElementById('edit_price-error').textContent = 'Price is required.';
                valid = false;
            }

            return valid;
        }
    </script>
</head>
<body>

<div class="container mt-5">
    <h2>Manage Products</h2>

    <!-- Add Product Form -->
    <div class="mb-4">
        <h4>Add New Product</h4>
        <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title">
                <span id="title-error" class="form-error text-danger"></span>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" class="form-control" id="price" name="price">
                <span id="price-error" class="form-error text-danger"></span>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control" id="image" name="image">
                <span id="image-error" class="form-error text-danger"></span>
            </div>
            <button type="submit" class="btn btn-primary" name="add_product">Add Product</button>
        </form>
    </div>

    <!-- Products List -->
    <div class="mb-4">
        <h4>Product List</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example product rows -->
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><img src="images/<?php echo $row['image']; ?>" alt="Product Image" width="100"></td>
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
                                    <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validateEditForm()">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <div class="form-group">
                                            <label for="edit_title">Title</label>
                                            <input type="text" class="form-control" id="edit_title" name="title" value="<?php echo $row['title']; ?>">
                                            <span id="edit_title-error" class="form-error text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_price">Price</label>
                                            <input type="text" class="form-control" id="edit_price" name="price" value="<?php echo $row['price']; ?>">
                                            <span id="edit_price-error" class="form-error text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_image">Image</label>
                                            <input type="file" class="form-control" id="edit_image" name="image">
                                            <img src="images/<?php echo $row['image']; ?>" alt="Product Image" width="100" class="mt-2">
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

<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
