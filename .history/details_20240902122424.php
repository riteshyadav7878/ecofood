<?php
// Include your database connection file
include 'conn.php'; // Ensure conn.php is correctly connecting to your database

// Fetch all products from the database
$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product List</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-image {
            position: relative;
            cursor: pointer; /* Show pointer cursor */
        }

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
    </style>
</head>
<body>

<div class="container mt-5">
    <h2>Product List</h2>

    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-3 mb-4">
                <div class="product-image" data-toggle="modal" data-target="#productModal"
                    data-title="<?php echo $row['title']; ?>"
                    data-price="<?php echo $row['price']; ?>"
                    data-image="images/<?php echo $row['image']; ?>"
                    data-id="<?php echo $row['id']; ?>">
                    <img src="images/<?php echo $row['image']; ?>" alt="Product Image" class="img-fluid">
                    <?php if (!empty($row['status'])): ?>
                        <div class="product-status <?php echo $row['status']; ?>">
                            <span><?php echo strtoupper($row['status']); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php } ?>
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
