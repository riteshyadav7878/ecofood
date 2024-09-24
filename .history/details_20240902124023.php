<?php
// Include your database connection file
include 'conn.php';

// Fetch all products from the database
$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Gallery</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-image {
            cursor: pointer; /* Show pointer cursor */
        }
        .modal-body img {
            max-width: 100%;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2>Product Gallery</h2>

    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="images/<?php echo $row['image']; ?>" class="card-img-top product-image" 
                        data-toggle="modal" data-target="#productModal"
                        data-title="<?php echo $row['title']; ?>"
                        data-price="<?php echo $row['price']; ?>"
                        data-image="images/<?php echo $row['image']; ?>"
                        data-description="<?php echo $row['description']; ?>"
                        data-id="<?php echo $row['id']; ?>"
                        alt="Product Image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['title']; ?></h5>
                        <p class="card-text"><?php echo $row['price']; ?></p>
                    </div>
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
                <img id="modalImage" src="" alt="Product Image" class="img-fluid mb-3">
                <h5 id="modalTitle"></h5>
                <p id="modalPrice"></p>
                <p id="modalDescription"></p>
                <form action="add_to_cart.php" method="POST">
                    <input type="hidden" name="product_id" id="modalProductId">
                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Populate the product details modal when an image is clicked
    $('.product-image').on('click', function () {
        var title = $(this).data('title');
        var price = $(this).data('price');
        var image = $(this).data('image');
        var description = $(this).data('description');
        var id = $(this).data('id');

        $('#productModal').find('#modalTitle').text(title);
        $('#productModal').find('#modalPrice').text('Price: $' + price);
        $('#productModal').find('#modalImage').attr('src', image);
        $('#productModal').find('#modalDescription').text(description);
        $('#productModal').find('#modalProductId').val(id);
    });
</script>

</body>
</html>
