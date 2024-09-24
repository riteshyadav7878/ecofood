<?php
session_name("user_session");
session_start();

include 'conn.php';
// If the user is already logged in, redirect them to the protected page
if (isset($_SESSION['username'])) {
    header("Location: shop-list-without-sidebar.php");
    exit();
}

// Fetch all active sliders
$sql_slider = "SELECT * FROM slider WHERE status='active'";
$result_slider = $conn->query($sql_slider);

// Fetch all products from the database in descending order
$sql_products = "SELECT * FROM product ORDER BY id DESC";
$result_products = mysqli_query($conn, $sql_products);

// Check for query execution errors
if (!$result_products) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="fonts/fonts.css" rel="stylesheet">
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Carousel styles */
        .carousel-item img {
            width: 100%;
            height: 500px;
            object-fit: cover;
            border: 5px solid #fff;
            border-radius: 10px;
        }
        .carousel-caption {
            text-align: center;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 15px;
            border-radius: 5px;
        }
        .carousel-caption h5 {
            font-size: 3rem;
        }
        .carousel-caption p {
            font-size: 2rem;
        }
        /* Product section styles */
        .product-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .product-item {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            width: 23%;
            border-radius: 10px;
        }
        .product-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <!-- Navbar and Header -->
    <?php include 'Navbar.php'; ?>

    <!-- Carousel Section -->
    <section>
        <div id="carouselExampleIndicators" class="carousel slide">
            <ol class="carousel-indicators">
                <?php $i = 0;
                while ($row_slider = $result_slider->fetch_assoc()): ?>
                    <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i; ?>" class="<?php echo $i == 0 ? 'active' : ''; ?>"></li>
                <?php $i++;
                endwhile; ?>
            </ol>
            <div class="carousel-inner">
                <?php
                $result_slider->data_seek(0); // Reset result pointer to the start
                $i = 0;
                while ($row_slider = $result_slider->fetch_assoc()):
                ?>
                    <div class="carousel-item <?php echo $i == 0 ? 'active' : ''; ?>">
                        <img src="<?php echo $row_slider['image_url']; ?>" class="d-block w-100" alt="<?php echo htmlspecialchars($row_slider['title']); ?>">
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?php echo htmlspecialchars($row_slider['title']); ?></h5>
                            <p><?php echo htmlspecialchars($row_slider['description']); ?></p>
                        </div>
                    </div>
                <?php $i++;
                endwhile; ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </section>

    <!-- Welcome Section -->
    <section>
        <div class="section grey-background p-t-100 p-b-100">
            <div class="container">
                <div class="heading-section-1">
                    <h3>WELCOME TO OUR FARM</h3>
                </div>
                <p>CELEBRATE SPRING AT OUR FARM!</p>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section>
        <div class="container p-t-100 p-b-100">
            <div class="heading-section-1">
                <h3>Our Products</h3>
            </div>
            <div class="product-grid">
                <?php while ($row_product = mysqli_fetch_assoc($result_products)): ?>
                    <div class="product-item">
                        <img src="<?php echo $row_product['image_url']; ?>" alt="<?php echo htmlspecialchars($row_product['name']); ?>">
                        <h5><?php echo htmlspecialchars($row_product['name']); ?></h5>
                        <p>₹<?php echo number_format($row_product['price'], 2); ?></p>
                        <a href="product-details.php?id=<?php echo $row_product['id']; ?>" class="btn btn-primary">View Details</a>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
