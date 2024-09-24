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
            z-index: 10; /* Ensure it appears above the image */
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
            display: block;
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
                <div class="card">
                    <div class="product-image">
                        <?php if (!empty($row['status'])): ?>
                            <div class="product-status <?php echo $row['status']; ?>">
                                <span><?php echo strtoupper($row['status']); ?></span>
                            </div>
                        <?php endif; ?>
                        <img src="images/<?php echo $row['image']; ?>" alt="Product Image">
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

</body>
</html>
