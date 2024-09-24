
<?php
// Include your database connection file
include 'conn.php'; 

// Fetch all products from the database
$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>

<!-- [if gt IE 8] <!-->
<html class="no-js" lang="en">
<!-- <![endif]-->

<!-- Mirrored from freebw.com/templates/ecofood/shop-list-without-sidebar.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 29 Aug 2024 05:33:26 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>

<meta charset="UTF-8">
<title>Shop list without sidebar - Ecofood html5 templates</title>
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
<link href="css/main.css" rel="stylesheet">
<link href="css/switcher.css" rel="stylesheet">
<link href="css/colors/green.css" rel="stylesheet" id="colors">
<link href="css/retina.css" rel="stylesheet">

<link rel="shortcut icon" href="favicon.png">
<link rel="apple-touch-icon" href="apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.html">
<script src="js/modernizr-custom.js"></script>

<style>
    .product-1 {
    border: 1px solid #ddd; /* Optional: Adds a border around the product card */
    padding: 15px;
    margin-bottom: 30px; /* Adjust as needed */
    background-color: #fff; /* Optional: Adds a background color */
    display: flex;
    flex-direction: column;
    height: 100%;
}


.product-image .image-holder {
    width: 100%;
    height: 200px; /* Set a fixed height for consistency */
    overflow: hidden;
}

.product-image .image-holder img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Ensures the image covers the holder without distortion */
}

.product-content {
    padding: 10px 0;
}

.product-content .title {
    font-size: 1.1em;
    margin-bottom: 10px;
}

.product-content .price {
    font-size: 1.2em;
    color: #333;
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
<header>

<div class="section dark-background">
<div class="container">
<div class="header-2">
<div class="header-left">
<p>
<i class="fa fa-map-marker"></i>256 Address Name, New York city
<span>|</span>
<i class="fa fa-clock-o"></i>07:30 Am - 11:00 Pm</p>
</div>
<div class="header-right">
<div class="header-login">
<a href="login.php">
<i class="fa fa-user"></i>Log in</a>
<span>/</span>
<a href="register.php">Register</a>
</div>
<span class="divider">|</span>
<div class="header-search">
<button class="fa fa-search"></button>
<div class="search-box">
<input type="text" placeholder="Search..." />
</div>
</div>
</div>
</div>
</div>
</div>

</header>
<?php include 'Navbar.php'; ?>
 
<section>
<div class="section primary-color-background">
<div class="container">
<div class="p-t-70 p-b-85">

<div class="heading-page-1">
<h3>Shop Categories</h3>
</div>
</div>
</div>
</div>
<div class="section border-bottom-grey">
<div class="container">
<div class="breadcrumb-1">
<ul>
<li>
<a href="index.php">Home</a>
</li>
<li>
<a href="shop-list-with-sidebar.php">Shop</a>
</li>
</ul>
</div>
</div>
</div>
</section>
<div class="page-content p-t-40 p-b-100">
<div class="container">
<div class="m-b-35">

<div class="sort-widget-1">
<div class="text-result">
<p>Showing 1–12 of 28 results</p>
</div>
<div class="select-sort">
<select>
<option value="something">Sort by default</option>
</select>
</div>
</div>

<div class="page-content p-t-40 p-b-100">
    <div class="container">
       
        <div class="row">

         <!-- sa-->
    <!-- <div class="page-content p-t-40 p-b-100">
        <div class="container"> -->
        
            
            <div class="row">
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="product-1">
                            <div class="product-image">
                                <div class="image-holder">
                                    <img src="images/<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" />
                                </div>
                            </div>
                            <div class="product-content">
                                <h3 class="title">
                                    <a class="name" href="product-details-1.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['title']); ?></a>
                                </h3>
                                <p class="price">$<?php echo htmlspecialchars($row['price']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <!-- </div>
</div> -->

<div class="container mt-5">
    <h2>Product List</h2>
    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="product-image">
                        <img src="images/<?php echo $row['image']; ?>" alt="Product Image">
                        <?php if (!empty($row['status'])): ?>
                            <div class="product-status <?php echo $row['status']; ?>">
                                <span><?php echo strtoupper($row['status']); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['title']; ?></h5>
                        <p class="card-text">Price: $<?php echo $row['price']; ?></p>
                                                    <span><?php echo strtoupper($row['status']); ?></span>

                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>


<!--dda -->

            
            <!-- <div class="col-md-3 col-sm-6">
                <div class="product-1">
                    <div class="product-image">
                        <div class="image-holder">
                            <img src="images/product-item-01.jpg" alt="Egg free mayo" />
                        </div>
                    
                    </div>
                    <div class="product-content">
                        <h3 class="title">
                            <a class="name" href="product-details-1.php">Egg free mayo</a>
                        </h3>
                        <p class="price">$ 10.00</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="product-1">
                    <div class="product-image">
                        <div class="image-holder">
                            <img src="images/product-item-02.jpg" alt="Organic broccoli" />
                        </div>
                    
                    </div>
                    <div class="product-content">
                        <h3 class="title">
                            <a class="name" href="product-details-1.php">Organic broccoli</a>
                        </h3>
                        <p class="price">$2.29 /bunch</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="product-1">
                    <div class="product-image">
                        <div class="image-holder">
                            <img src="images/product-item-03.jpg" alt="Strawberries" />
                        </div>
                     
                    </div>
                    <div class="product-content">
                        <h3 class="title">
                            <a class="name" href="product-details-1.php">Strawberries</a>
                        </h3>
                        <p class="price">$5.99 /ea</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="product-1">
                    <div class="product-image">
                        <div class="image-holder">
                            <img src="images/product-item-05.jpg" alt="Fresh cherry" />
                        </div>
                  
                    </div>
                    <div class="product-content">
                        <h3 class="title">
                            <a class="name" href="product-details-1.php">Fresh cherry</a>
                        </h3>
                        <p class="price">$12.48 /bag</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="product-1">
                    <div class="product-image">
                        <div class="image-holder">
                            <img src="images/product-item-06.jpg" alt="Juice carrot &amp; apple" />
                        </div>
                      
                    </div>
                    <div class="product-content">
                        <h3 class="title">
                            <a class="name" href="product-details-1.php">Juice carrot &amp; apple</a>
                        </h3>
                        <p class="price">$10.00</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="product-1">
                    <div class="product-image">
                        <div class="image-holder">
                            <img src="images/product-item-07.jpg" alt="Organic banana" />
                        </div>
                      
                    </div>
                    <div class="product-content">
                        <h3 class="title">
                            <a class="name" href="product-details-1.php">Organic banana</a>
                        </h3>
                        <p class="price">$2.76 /bunch</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="product-1">
                    <div class="product-image">
                        <div class="image-holder">
                            <img src="images/product-item-04.jpg" alt="Fresh drinks" />
                        </div>
                       
                    </div>
                    <div class="product-content">
                        <h3 class="title">
                            <a class="name" href="product-details-1.php">Fresh drinks</a>
                        </h3>
                        <p class="price">$ 20.00</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="product-1">
                    <div class="product-image">
                        <div class="image-holder">
                            <img src="images/product-item-09.jpg" alt="Carrots" />
                        </div>
                     
                    </div>
                    <div class="product-content">
                        <h3 class="title">
                            <a class="name" href="product-details-1.php">Carrots</a>
                        </h3>
                        <p class="price">$2.29 /bunch</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="product-1">
                    <div class="product-image">
                        <div class="image-holder">
                            <img src="images/product-item-10.jpg" alt="Red cabbage approx" />
                        </div>
                        
                    </div>
                    <div class="product-content">
                        <h3 class="title">
                            <a class="name" href="product-details-1.php">Red cabbage approx</a>
                        </h3>
                        <p class="price">$3.00 /bunch</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="product-1">
                    <div class="product-image">
                        <div class="image-holder">
                            <img src="images/product-item-11.jpg" alt="Lemon" />
                        </div>
                     
                    </div>
                    <div class="product-content">
                        <h3 class="title">
                            <a class="name" href="product-details-1.php">Lemon</a>
                        </h3>
                        <p class="price">$20.00</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="product-1">
                    <div class="product-image">
                        <div class="image-holder">
                            <img src="images/product-item-08.jpg" alt="Fresh celery root" />
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
            <div class="col-md-3 col-sm-6">
                <div class="product-1">
                    <div class="product-image">
                        <div class="image-holder">
                            <img src="images/product-item-12.jpg" alt="Acai berry 250ml" />
                        </div>
          
                    </div>
                    <div class="product-content">
                        <h3 class="title">
                            <a class="name" href="product-details-1.php">Acai berry 250ml</a>
                        </h3>
                        <p class="price">$10.00</p>
                    </div>
                </div>
            </div> -->
            <!-- <div class="col-md-3 col-sm-6">
                <div class="product-1">
                    <div class="product-image">
                        <div class="image-holder">
                            <img src="images/product-item-13.jpg" alt="Uganda roast and ground" />
                        </div>
                        
                    </div>
                    <div class="product-content">
                        <h3 class="title">
                            <a class="name" href="product-details-1.php">Uganda roast and ground</a>
                        </h3>
                        <p class="price">$20.00 /bunch</p>
                    </div>
                </div>
            </div> -->
            <!-- <div class="col-md-3 col-sm-6">
                <div class="product-1">
                    <div class="product-image">
                        <div class="image-holder">
                            <img src="images/product-item-18.jpg" alt="mix tomato" />
                        </div>
                      
                    </div>
                    <div class="product-content">
                        <h3 class="title">
                            <a class="name" href="product-details-1.php">Mix Tomato</a>
                        </h3>
                        <p class="price">$30.00 /bunch</p>
                    </div>
                </div>
            </div> -->
            <!-- <div class="col-md-3 col-sm-6">
                <div class="product-1">
                    <div class="product-image">
                        <div class="image-holder">
                            <img src="images/product-item-17.jpg" alt="Mr Organic Vegetarian " />
                        </div>
                         
                    </div>
                    <div class="product-content">
                        <h3 class="title">
                            <a class="name" href="product-details-1.php">Mr Organic Vegetarian </a>
                        </h3>
                        <p class="price">$25.00 /bunch</p>
                    </div>
                </div>
            </div> -->
            <!-- <div class="col-md-3 col-sm-6">
                <div class="product-1">
                    <div class="product-image">
                        <div class="image-holder">
                            <img src="images/product-item-14.jpg" alt="Eggs 6x" />
                        </div>
                     
                    </div>
                    <div class="product-content">
                        <h3 class="title">
                            <a class="name" href="product-details-1.php">Eggs 6x</a>
                        </h3>
                        <p class="price">$12.00</p>
                    </div>
                </div>
            </div> -->
        </div>
        
    </div>
</div>

<div class="m-t-15">

<div class="pagination-widget-1">
<ul class="pagination-list">
<li class="prev">
<a href="#">
<i class="fa fa-angle-left"></i>
<span>Previous</span>
</a>
</li>
<li class="item active">
<a href="#">
<span>1</span>
</a>
</li>
<li class="item">
<a href="#">
<span>2</span>
</a>
</li>
<li class="item">
<a href="#">
<span>3</span>
</a>
</li>
<li class="next">
<a href="#">
<span>Next</span>
<i class="fa fa-angle-right"></i>
</a>
</li>
</ul>
</div>

</div>
</div>
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


<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vendor/retinajs/dist/retina.min.js"></script>
<script src="vendor/SmoothScroll/SmoothScroll.js"></script>
<script src="js/switcher-custom.js"></script>
<script src="js/main.js"></script>


</body>

<!-- Mirrored from freebw.com/templates/ecofood/shop-list-without-sidebar.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 29 Aug 2024 05:33:27 GMT -->
</html>