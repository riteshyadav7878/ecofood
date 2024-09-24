<?php
// Start the session
session_start();

// Include your database connection file
include 'conn.php';

// Fetch all products from the database
$sql = "SELECT * FROM products"; // Replace 'products' with your actual table name
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product List</title>
    <meta name="description" content="Ecofood theme template">
    <meta name="author" content="AuCreative">
    <meta name="keywords" content="Ecofood theme template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS Links -->
    <link href="fonts/fonts.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/colors/green.css" rel="stylesheet" id="colors">

    <style>
        body {
            background: linear-gradient(to right, #ffecd2, #fcb69f);
        }
        .product-container {
            background: #fff4e6;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        .product-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        .product-card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .product-card h3 {
            font-size: 1.25rem;
            margin: 10px 0;
        }
        .product-card p {
            font-size: 1rem;
        }
        .btn-primary {
            background-color: #ff7f50;
            border-color: #ff7f50;
        }
        .btn-primary:hover {
            background-color: #ff6347;
            border-color: #ff6347;
        }
    </style>
</head>
<body>

<?php include 'Unavbar.php'; ?>

<section>
    <div class="section primary-color-background">
        <div class="container">
            <div class="p-t-70 p-b-85">
                <div class="heading-page-1">
                    <h3>Product List</h3>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="product-container">
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-12 col-md-4">
                        <div class="product-card">
                            <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                            <p>Price: $<?php echo htmlspecialchars($row['price']); ?></p>
                            <p>Description: <?php echo htmlspecialchars($row['description']); ?></p>
                            <a href="product-details.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center">No products found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'Footer.php'; ?>

<!-- JavaScript Files -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
