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
    <title>Product List</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
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
            display: inline-block;
        }

        .product-image img {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2>Product List</h2>
    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-4 mb-4">
                <div class="product-image" 
                     data-toggle="modal" 
                     data-target="#productModal"
                     data-title="<?php echo $row['title']; ?>"
                     data-price="<?php echo $row['price']; ?>"
                     data-image="images/<?php echo $row['image']; ?>"
                     data-description="<?php echo $row['description']; ?>"
                     data-id="<?php echo $row['id']; ?>">
                    <img src="images/<?php echo $row['image']; ?>" alt="Product Image">
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
                    <p id="modalDescription"></p>
                    <a id="modalUrl" href="" target="_blank">View Product URL</a>
                </div>
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
        var productUrl = 'product_details.php?id=' + id; // URL for detailed product view

        $('#productModal').find('#modalTitle').text(title);
        $('#productModal').find('#modalPrice').text('Price: $' + price);
        $('#productModal').find('#modalImage').attr('src', image);
        $('#productModal').find('#modalDescription').text(description);
        $('#productModal').find('#modalUrl').attr('href', productUrl);
    });
</script>

</body>
</html>
