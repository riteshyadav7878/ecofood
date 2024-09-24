<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Products</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/admin.css" rel="stylesheet">
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
    </style>
</head>
<body>

<div class="container mt-5">
    <h2>Manage Products</h2>

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
                <label for="image">Image</label>
                <input type="file" class="form-control" id="image" name="image" required>
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
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td>
                            <div class="product-image" data-toggle="modal" data-target="#productModal" 
                                data-title="<?php echo $row['title']; ?>"
                                data-price="<?php echo $row['price']; ?>"
                                data-image="images/<?php echo $row['image']; ?>"
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
                <div id="productDetails">
                    <img id="modalImage" src="" alt="Product Image" class="img-fluid mb-3">
                    <h5 id="modalTitle"></h5>
                    <p id="modalPrice"></p>
                    <form action="add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" id="modalProductId">
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Populate the modal with product details when an image is clicked
    $('#productModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var title = button.data('title'); // Extract info from data-* attributes
        var price = button.data('price');
        var image = button.data('image');
        var id = button.data('id');

        var modal = $(this);
        modal.find('#modalTitle').text(title);
        modal.find('#modalPrice').text('Price: $' + price);
        modal.find('#modalImage').attr('src', image);
        modal.find('#modalProductId').val(id);
    });
</script>

</body>
</html>
