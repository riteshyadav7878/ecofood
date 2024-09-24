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
<body><!-- Front-Facing Product List -->
<!-- Front-Facing Product List -->
<div class="container mt-5">
    <h2>Product List</h2>
    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="product-image" style="position: relative;"> <!-- Add relative positioning here -->
                        <img src="images/<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" class="img-fluid">
                        <?php if (!empty($row['status'])): ?>
                            <div class="product-status <?php echo $row['status']; ?>" style="position: absolute; top: 10px; left: 10px; padding: 5px 10px; background-color: rgba(0,0,0,0.7); color: white; font-weight: bold; border-radius: 3px;">
                                <span><?php echo strtoupper($row['status']); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                        <p class="card-text">Price: $<?php echo htmlspecialchars($row['price']); ?></p>
                    </div>
                </div>
            </div>
        <?php } ?>
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
