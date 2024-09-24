<?php
session_start();
 include '';
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit();
}
?>
;

// Check if a product ID is provided
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // Fetch the product details from the database
    $sql = "SELECT * FROM product WHERE id = $product_id";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);

    if (!$product) {
        echo "Product not found!";
        exit;
    }
} else {
    echo "No product ID provided!";
    exit;
}
?>

<!DOCTYPE html>

<!-- [if gt IE 8] <!-->
<html class="no-js" lang="en">
<!-- <![endif]-->

<!-- Mirrored from freebw.com/templates/ecofood/product-details-1.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 29 Aug 2024 05:33:27 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>

<meta charset="UTF-8">
 
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
<title><?php echo htmlspecialchars($product['title']); ?> - Product Details</title>
    <meta name="description" content="<?php echo htmlspecialchars($product['description']); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
        .product-section {
            background-color: #f8f9fa;
            padding: 30px 0;
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
        }

        .product-image-container {
            position: relative;
            background-color: #ffffff;
            border: 2px solid #6c757d;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 100%;
        }

        .product-image-container img {
            width: 100%;
            display: block;
            border-radius: 5px;
        }

        .zoomed-image {
            position: absolute;
            top: 0;
            left: 100%;
            width: 200%;
            height: auto;
            border: 1px solid #ddd;
            background: #fff;
            transform: scale(0);
            transition: transform 0.5s ease;
            cursor: none;
            z-index: 10;
        }

        .product-image-container:hover .zoomed-image {
            transform: scale(1);
        }

        .product-image-container:hover {
            overflow: hidden;
        }

        .product-details {
            background-color: #ffffff;
            border: 2px solid #6c757d;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 100%;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }

        .quantity-selector input {
            width: 60px;
            text-align: center;
            border: 1px solid #ddd;
            padding: 5px;
            margin: 0 5px;
        }

        .quantity-selector button {
            background-color: #ff6600;
            border: none;
            color: white;
            padding: 5px 10px;
            cursor: pointer;
        }

        .quantity-selector button:hover {
            background-color: #e65c00;
        }

        .btn-primary {
            background-color: #ff6600;
            border-color: #ff6600;
        }

        .btn-primary:hover {
            background-color: #e65c00;
            border-color: #e65c00;
        }

        .btn-secondary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-secondary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .review-section {
            margin-top: 30px;
        }

        .review-section h3 {
            margin-bottom: 20px;
            color: #343a40;
        }

        .review {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .review p {
            margin: 0;
        }

        .review-form {
            margin-top: 30px;
        }

        .review-form textarea {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            resize: vertical;
        }

        .review-form button {
            background-color: #ff6600;
            border: none;
            color: white;
            padding: 10px 20px;
            cursor: pointer;
        }

        .review-form button:hover {
            background-color: #e65c00;
        }
    </style>
</head>
<body>

<div class="page-loader">
<div class="loader"></div>
</div>
<div id="switcher">
<span class="switcher-cog"></span>
<div class="mCustomScrollbar" data-mcs-theme="minimal-dark">
<a class="btn-buy" href="https://themeforest.net/cart/add_items?item_ids=20283248&amp;ref=authemes" target="_blank">Buy Now</a>
<div class="clearfix"></div>
<div class="m-b-50"></div>
<span class="sw-title">Main Colors:</span>
<ul id="tm-color">
<li class="color1"></li>
<li class="color2"></li>
<li class="color3"></li>
<li class="color4"></li>
<li class="color5"></li>
<li class="color6"></li>
<li class="color7"></li>
</ul>
<div class="m-b-50"></div>
<span class="sw-title">HomePage Layout</span>
<ul class="demo-homepage">
<li>
<a href="index.php">
<img src="images/home_1.jpg" alt />
</a>
<img class="popup-demo-homepage" src="images/home_1.jpg" alt="Image" />
</li>
 
</ul>
</div>
</div> 
<?php include 'Unavbar.php'; ?>
 
<section>
<div class="section primary-color-background">
<div class="container">
<div class="p-t-70 p-b-85">

<div class="heading-page-1">
<h3>Product Details</h3>
</div>
</div>
</div>
</div>
<div class="section border-bottom-grey">
<div class="container">
<div class="breadcrumb-1">
<ul>
 
<li>
<a href="shop-list-with-sidebar.php">Product Details</a>
</li>
 
</ul>
</div>
</div>
</div>
</section>

<!--Product -->
<section class="product-section">
        <div class="container">
            <div class="row product-container">
                <div class="col-md-6 col-lg-5 product-image-container">
                    <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="img-fluid" id="main-image" />
                    <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="zoomed-image" id="zoomed-image" />
                </div>
                <div class="col-md-6 col-lg-7 product-details">
                    <h1><?php echo htmlspecialchars($product['title']); ?></h1>
                    <p><strong>Price:</strong> $<?php echo htmlspecialchars($product['price']); ?></p>
                    <p><strong>Description:</strong></p>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <p><strong>Status:</strong> <?php echo ucfirst(htmlspecialchars($product['status'])); ?></p>

                    <div class="quantity-selector">
                        <button id="decrease-quantity" class="btn btn-primary">-</button>
                        <input type="number" id="quantity" value="1" min="1">
                        <button id="increase-quantity" class="btn btn-primary">+</button>
                    </div>

                    <a href="add_cart.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">Add to Cart</a>
                    <button onclick="window.history.back();" class="btn btn-secondary">Close</button>
                </div>
            </div>

            <div class="review-section">
                <h3>Reviews</h3>
                <?php
                // Fetch reviews for the product
                $review_sql = "SELECT * FROM reviews WHERE product_id = $product_id";
                $review_result = mysqli_query($conn, $review_sql);
                while ($review = mysqli_fetch_assoc($review_result)) {
                    echo '<div class="review">';
                    echo '<p><strong>' . htmlspecialchars($review['reviewer_name']) . ':</strong></p>';
                    echo '<p>' . htmlspecialchars($review['review_text']) . '</p>';
                    echo '</div>';
                }
                ?>

                <div class="review-form">
                    <h4>Write Your Own Review</h4>
                    <form action="submit_review.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <div class="mb-3">
                            <label for="reviewer-name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="reviewer-name" name="reviewer_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="review-text" class="form-label">Your Review</label>
                            <textarea class="form-control" id="review-text" name="review_text" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

<!-- Product -->
<section>
<div class="section white-background p-t-90">
<div class="container">

<div class="heading-section-1">
<h3>OTHER PRODUCTS</h3>
</div>
<div class="owl-carousel product-list-carousel-1 m-t-50" data-carousel-items="4" data-carousel-nav="true" data-carousel-autoplay="true" data-carousel-loop="true" data-carousel-xs="1" data-carousel-sm="2" data-carousel-md="2" data-carousel-lg="4">

<div class="product-1">
<div class="product-image">
<div class="image-holder">
<img src="images/product-item-01.jpg" alt="Egg free mayo" />
</div>
<div class="product-status hot">
<span>HOT</span>
</div>
<div class="product-action">
<div class="product-action-list">
<div class="action-item">
<a class="fa fa-search-plus" href="#" data-toggle="modal" data-target="#myModal" data-toggle-tooltip="tooltip" data-placement="top" title="Quick view"></a>
</div>
<div class="action-item">
<a class="fa fa-shopping-cart" href="shopping-cart.php" data-toggle-tooltip="tooltip" data-placement="top" title="Add to cart"></a>
</div>
<div class="action-item">
<a class="fa fa-heart" href="wishlist-page.php" data-toggle-tooltip="tooltip" data-placement="top" title="Add to wishlist!"></a>
</div>
</div>
</div>
</div>
<div class="product-content">
<h3 class="title">
<a class="name" href="product-details-1.php">Egg free mayo</a>
</h3>
<p class="price">$ 10.00</p>
</div>
</div>


<div class="product-1">
<div class="product-image">
<div class="image-holder">
<img src="images/product-item-02.jpg" alt="Organic broccoli" />
</div>
<div class="product-action">
<div class="product-action-list">
<div class="action-item">
<a class="fa fa-search-plus" href="#" data-toggle="modal" data-target="#myModal" data-toggle-tooltip="tooltip" data-placement="top" title="Quick view"></a>
</div>
<div class="action-item">
<a class="fa fa-shopping-cart" href="shopping-cart.php" data-toggle-tooltip="tooltip" data-placement="top" title="Add to cart"></a>
</div>
<div class="action-item">
<a class="fa fa-heart" href="wishlist-page.php" data-toggle-tooltip="tooltip" data-placement="top" title="Add to wishlist!"></a>
</div>
</div>
</div>
</div>
<div class="product-content">
<h3 class="title">
<a class="name" href="product-details-1.php">Organic broccoli</a>
</h3>
<p class="price">$2.29 /bunch</p>
</div>
</div>


<div class="product-1">
<div class="product-image">
<div class="image-holder">
<img src="images/product-item-03.jpg" alt="Strawberries" />
</div>
<div class="product-status sale">
<span>SALE</span>
</div>
<div class="product-action">
<div class="product-action-list">
<div class="action-item">
<a class="fa fa-search-plus" href="#" data-toggle="modal" data-target="#myModal" data-toggle-tooltip="tooltip" data-placement="top" title="Quick view"></a>
</div>
<div class="action-item">
<a class="fa fa-shopping-cart" href="shopping-cart.php" data-toggle-tooltip="tooltip" data-placement="top" title="Add to cart"></a>
</div>
<div class="action-item">
<a class="fa fa-heart" href="wishlist-page.php" data-toggle-tooltip="tooltip" data-placement="top" title="Add to wishlist!"></a>
</div>
</div>
</div>
</div>
<div class="product-content">
<h3 class="title">
<a class="name" href="product-details-1.php">Strawberries</a>
</h3>
<p class="price">$5.99 /ea</p>
</div>
</div>


<div class="product-1">
<div class="product-image">
<div class="image-holder">
<img src="images/product-item-04.jpg" alt="Lemon 250ml glass" />
</div>
<div class="product-action">
<div class="product-action-list">
<div class="action-item">
<a class="fa fa-search-plus" href="#" data-toggle="modal" data-target="#myModal" data-toggle-tooltip="tooltip" data-placement="top" title="Quick view"></a>
</div>
<div class="action-item">
<a class="fa fa-shopping-cart" href="shopping-cart.php" data-toggle-tooltip="tooltip" data-placement="top" title="Add to cart"></a>
</div>
<div class="action-item">
<a class="fa fa-heart" href="wishlist-page.php" data-toggle-tooltip="tooltip" data-placement="top" title="Add to wishlist!"></a>
</div>
</div>
</div>
</div>
<div class="product-content">
<h3 class="title">
<a class="name" href="product-details-1.php">Lemon 250ml glass</a>
</h3>
<p class="price">$20.00</p>
</div>
</div>


<div class="product-1">
<div class="product-image">
<div class="image-holder">
<img src="images/product-item-05.jpg" alt="Fresh cherry" />
</div>
<div class="product-action">
<div class="product-action-list">
<div class="action-item">
<a class="fa fa-search-plus" href="#" data-toggle="modal" data-target="#myModal" data-toggle-tooltip="tooltip" data-placement="top" title="Quick view"></a>
</div>
<div class="action-item">
<a class="fa fa-shopping-cart" href="shopping-cart.php" data-toggle-tooltip="tooltip" data-placement="top" title="Add to cart"></a>
</div>
<div class="action-item">
<a class="fa fa-heart" href="wishlist-page.php" data-toggle-tooltip="tooltip" data-placement="top" title="Add to wishlist!"></a>
</div>
</div>
</div>
</div>
<div class="product-content">
<h3 class="title">
<a class="name" href="product-details-1.php">Fresh cherry</a>
</h3>
<p class="price">$12.48 /bag</p>
</div>
</div>


<div class="product-1">
<div class="product-image">
<div class="image-holder">
<img src="images/product-item-06.jpg" alt="Juice carrot &amp; apple" />
</div>
<div class="product-status new">
<span>NEW</span>
</div>
<div class="product-action">
<div class="product-action-list">
<div class="action-item">
<a class="fa fa-search-plus" href="#" data-toggle="modal" data-target="#myModal" data-toggle-tooltip="tooltip" data-placement="top" title="Quick view"></a>
</div>
<div class="action-item">
<a class="fa fa-shopping-cart" href="shopping-cart.php" data-toggle-tooltip="tooltip" data-placement="top" title="Add to cart"></a>
</div>
<div class="action-item">
<a class="fa fa-heart" href="wishlist-page.php" data-toggle-tooltip="tooltip" data-placement="top" title="Add to wishlist!"></a>
</div>
</div>
</div>
</div>
<div class="product-content">
<h3 class="title">
<a class="name" href="product-details-1.php">Juice carrot &amp; apple</a>
</h3>
<p class="price">$10.00</p>
</div>
</div>


<div class="product-1">
<div class="product-image">
<div class="image-holder">
<img src="images/product-item-07.jpg" alt="Organic banana" />
</div>
<div class="product-action">
<div class="product-action-list">
<div class="action-item">
<a class="fa fa-search-plus" href="#" data-toggle="modal" data-target="#myModal" data-toggle-tooltip="tooltip" data-placement="top" title="Quick view"></a>
</div>
<div class="action-item">
<a class="fa fa-shopping-cart" href="shopping-cart.php" data-toggle-tooltip="tooltip" data-placement="top" title="Add to cart"></a>
</div>
<div class="action-item">
<a class="fa fa-heart" href="wishlist-page.php" data-toggle-tooltip="tooltip" data-placement="top" title="Add to wishlist!"></a>
</div>
</div>
</div>
</div>
<div class="product-content">
<h3 class="title">
<a class="name" href="product-details-1.php">Organic banana</a>
</h3>
<p class="price">$2.76 /bunch</p>
</div>
</div>


<div class="product-1">
<div class="product-image">
<div class="image-holder">
<img src="images/product-item-08.jpg" alt="Fresh celery root" />
</div>
<div class="product-action">
<div class="product-action-list">
<div class="action-item">
<a class="fa fa-search-plus" href="#" data-toggle="modal" data-target="#myModal" data-toggle-tooltip="tooltip" data-placement="top" title="Quick view"></a>
</div>
<div class="action-item">
<a class="fa fa-shopping-cart" href="shopping-cart.php" data-toggle-tooltip="tooltip" data-placement="top" title="Add to cart"></a>
</div>
<div class="action-item">
<a class="fa fa-heart" href="wishlist-page.php" data-toggle-tooltip="tooltip" data-placement="top" title="Add to wishlist!"></a>
</div>
</div>
</div>
</div>
<div class="product-content">
<h3 class="title">
<a class="name" href="product-details-1.php">Fresh celery root</a>
</h3>
<p class="price">$2.49 /bunch</p>
</div>
</div>

</div>
</div>
</div>
</section>
</div>
<?php include 'Footer.php'; ?> 
 

<div class="modal fade quick-view-1" id="myModal" role="dialog">
<div class="modal-dialog">

<div class="modal-content">
<div class="modal-header">
<button class="fa fa-close" type="button" data-dismiss="modal"></button>
</div>
<div class="modal-body">
<div class="row">
<div class="col-md-5">

<div class="product-detail-image-1">
<div class="product-primary-image owl-carousel" data-carousel-items="1" data-carousel-dotsData="true" data-carousel-nav="true" data-carousel-dots="true" data-carousel-xs="1" data-carousel-sm="1" data-carousel-md="1" data-carousel-lg="1" data-carousel-animateout="fadeOut" data-carousel-animatein="fadeIn">
<img data-dot="&lt;img src='images/product-details-image-05.jpg'&gt;" src="images/product-details-image-02.jpg" alt="product detail image" />
<img data-dot="&lt;img src='images/product-details-image-06.jpg'&gt;" src="images/product-details-image-03.jpg" alt="product detail image" />
<img data-dot="&lt;img src='images/product-details-image-07.jpg'&gt;" src="images/product-details-image-04.jpg" alt="product detail image" />
<img data-dot="&lt;img src='images/product-details-image-08.jpg'&gt;" src="images/product-details-image-01.jpg" alt="product detail image" />
</div>
</div>

</div>
<div class="col-md-7">

<div class="product-detail-content-1">
<div class="product-name">
<h3>Organic strawberries</h3>
</div>
<div class="product-cert">
<a href="#">
<img src="images/icons/ic-product-cert-01.png" alt="product cert" />
</a>
<a href="#">
<img src="images/icons/ic-product-cert-02.png" alt="product cert" />
</a>
<a href="#">
<img src="images/icons/ic-product-cert-03.png" alt="product cert" />
</a>
</div>
<div class="product-price">
<p>$5.99 /ea</p>
</div>
<div class="product-introduce">
<p>Morbi molestie nisi purus, vitae vestibulum turpis lacinia sit amet. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia.</p>
<p>In Stock</p>
<p>SKU: 1952C14</p>
</div>
<div class="prodcut-add-to-cart">
<input class="input-size" type="text" value="1" />
<button class="au-btn au-btn-primary au-btn-radius btn-add-to-cart" type="submit">ADD TO CART</button>
<a class="au-btn au-btn-border au-btn-radius btn-add-to-wishlist" href="#">ADD TO WISHLIST</a>
</div>
</div>

</div>
</div>
</div>
</div>
</div>
</div>

<div id="up-to-top">
<i class="fa fa-angle-up"></i>
</div>




<!--example  -->



<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vendor/retinajs/dist/retina.min.js"></script>
<script src="vendor/SmoothScroll/SmoothScroll.js"></script>
<script src="js/switcher-custom.js"></script>
<script src="vendor/owl.carousel/dist/owl.carousel.min.js"></script>
<script src="vendor/jquery-accordion/js/jquery.accordion.js"></script>
<script src="js/owl-custom.js"></script>
<script src="js/accordion-custom.js"></script>
<script src="js/main.js"></script>


<script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            const mainImage = $('#main-image');
            const zoomedImage = $('#zoomed-image');

            mainImage.on('mousemove', function (e) {
                const offset = mainImage.offset();
                const x = e.pageX - offset.left;
                const y = e.pageY - offset.top;
                const xPercent = (x / mainImage.width()) * 100;
                const yPercent = (y / mainImage.height()) * 100;

                zoomedImage.css('transform-origin', `${xPercent}% ${yPercent}%`);
                zoomedImage.css('background-image', `url('${mainImage.attr('src')}')`);
                zoomedImage.css('display', 'block');
            });

            mainImage.on('mouseleave', function () {
                zoomedImage.css('display', 'none');
            });

            // Quantity selector functionality
            $('#increase-quantity').click(function () {
                const quantityInput = $('#quantity');
                quantityInput.val(parseInt(quantityInput.val()) + 1);
            });

            $('#decrease-quantity').click(function () {
                const quantityInput = $('#quantity');
                const currentValue = parseInt(quantityInput.val());
                if (currentValue > 1) {
                    quantityInput.val(currentValue - 1);
                }
            });
        });
    </script>
</body>

<!-- Mirrored from freebw.com/templates/ecofood/product-details-1.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 29 Aug 2024 05:33:27 GMT -->
</html>