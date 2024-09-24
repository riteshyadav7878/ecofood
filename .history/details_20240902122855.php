<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List with Modals</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .product-1 {
            margin-bottom: 30px;
        }
        .product-image .image-holder img {
            width: 100%;
            height: auto;
        }
        .product-status {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .product-status.hot {
            background: #ff6f61;
        }
        .product-status.sale {
            background: #f0ad4e;
        }
        .product-status.new {
            background: #5bc0de;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <div class="row">
        <!-- Product 1 -->
        <div class="col-md-3 col-sm-6">
            <div class="product-1">
                <div class="product-image">
                    <div class="image-holder">
                        <a href="#" data-toggle="modal" data-target="#productDetailsModal01">
                            <img src="images/product-item-01.jpg" alt="Egg free mayo" />
                        </a>
                    </div>
                    <div class="product-status hot">
                        <span>HOT</span>
                    </div>
                </div>
                <div class="product-content">
                    <h3 class="title">
                        <a class="name" href="#" data-toggle="modal" data-target="#productDetailsModal01">Egg free mayo</a>
                    </h3>
                    <p class="price">$10.00</p>
                </div>
            </div>
        </div>

        <!-- Product 2 -->
        <div class="col-md-3 col-sm-6">
            <div class="product-1">
                <div class="product-image">
                    <div class="image-holder">
                        <a href="#" data-toggle="modal" data-target="#productDetailsModal02">
                            <img src="images/product-item-02.jpg" alt="Organic broccoli" />
                        </a>
                    </div>
                </div>
                <div class="product-content">
                    <h3 class="title">
                        <a class="name" href="#" data-toggle="modal" data-target="#productDetailsModal02">Organic broccoli</a>
                    </h3>
                    <p class="price">$2.29 /bunch</p>
                </div>
            </div>
        </div>

        <!-- Product 3 -->
        <div class="col-md-3 col-sm-6">
            <div class="product-1">
                <div class="product-image">
                    <div class="image-holder">
                        <a href="#" data-toggle="modal" data-target="#productDetailsModal03">
                            <img src="images/product-item-03.jpg" alt="Strawberries" />
                        </a>
                    </div>
                    <div class="product-status sale">
                        <span>SALE</span>
                    </div>
                </div>
                <div class="product-content">
                    <h3 class="title">
                        <a class="name" href="#" data-toggle="modal" data-target="#productDetailsModal03">Strawberries</a>
                    </h3>
                    <p class="price">$5.99 /ea</p>
                </div>
            </div>
        </div>

        <!-- Product 4 -->
        <div class="col-md-3 col-sm-6">
            <div class="product-1">
                <div class="product-image">
                    <div class="image-holder">
                        <a href="#" data-toggle="modal" data-target="#productDetailsModal04">
                            <img src="images/product-item-04.jpg" alt="Lemon 250ml glass" />
                        </a>
                    </div>
                </div>
                <div class="product-content">
                    <h3 class="title">
                        <a class="name" href="#" data-toggle="modal" data-target="#productDetailsModal04">Lemon 250ml glass</a>
                    </h3>
                    <p class="price">$20.00</p>
                </div>
            </div>
        </div>

        <!-- Add additional products here -->

    </div>
</div>

<!-- Modals -->

<!-- Modal for Egg Free Mayo -->
<div class="modal fade" id="productDetailsModal01" tabindex="-1" role="dialog" aria-labelledby="productDetailsModalLabel01" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productDetailsModalLabel01">Egg Free Mayo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="images/product-item-01.jpg" alt="Egg Free Mayo" class="img-fluid mb-3">
                <p><strong>Price:</strong> $10.00</p>
                <p><strong>Description:</strong> Delicious egg-free mayonnaise, perfect for sandwiches and salads.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="shopping-cart.php" class="btn btn-primary">Add to Cart</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Organic Broccoli -->
<div class="modal fade" id="productDetailsModal02" tabindex="-1" role="dialog" aria-labelledby="productDetailsModalLabel02" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productDetailsModalLabel02">Organic Broccoli</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="images/product-item-02.jpg" alt="Organic Broccoli" class="img-fluid mb-3">
                <p><strong>Price:</strong> $2.29 / bunch</p>
                <p><strong>Description:</strong> Fresh and organic broccoli, perfect for healthy meals.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="shopping-cart.php" class="btn btn-primary">Add to Cart</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Strawberries -->
<div class="modal fade" id="productDetailsModal03" tabindex="-1" role="dialog" aria-labelledby="productDetailsModalLabel03" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productDetailsModalLabel03">Strawberries</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="images/product-item-03.jpg" alt="Strawberries" class="img-fluid mb-3">
                <p><strong>Price:</strong> $5.99 / ea</p>
                <p><strong>Description:</strong> Juicy and sweet strawberries, great for desserts and snacks.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="shopping-cart.php" class="btn btn-primary">Add to Cart</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Lemon 250ml Glass -->
<div class="modal fade" id="productDetailsModal04" tabindex="-1" role="dialog" aria-labelledby="productDetailsModalLabel04" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productDetailsModalLabel04">Lemon 250ml Glass</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="images/product-item-04.jpg" alt="Lemon 250ml Glass" class="img-fluid mb-3">
                <p><strong>Price:</strong> $20.00</p>
                <p><strong>Description:</strong> Stylish lemon glass, perfect for beverages.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="shopping-cart.php" class="btn btn-primary">Add to Cart</a>
            </div>
        </div>
    </div>
</div>

<!-- Add additional modals here -->

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
