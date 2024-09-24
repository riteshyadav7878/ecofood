<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/main.css" rel="stylesheet">
    <style>
        /* Make quantity input smaller */
        .quantity-input {
            width: 60px; /* Smaller width for quantity input */
        }

        /* Make images smaller */
        .cart-image {
            width: 40px; /* Smaller image size */
        }

        /* Limit table width */
        .cart-table {
            max-width: 800px; /* Set max-width for the table */
            margin: auto; /* Center the table */
        }

        /* Adjust column widths */
        .table td, .table th {
            padding: 0.75rem; /* Reduce padding */
            text-align: center; /* Center align text */
        }

        /* For small screens, make the table scrollable */
        @media (max-width: 768px) {
            .table-responsive {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
        }
    </style>
</head>
<body>

<header>
    <?php include 'Unavbar.php'; ?>
</header>

<section>
<div class="section primary-color-background">
<div class="container">
<div class="p-t-70 p-b-85">

<div class="heading-page-1">
<h3>Your Cart</h3>
</div>
</div>
</div>
</div>
<div class="section border-bottom-grey">
<div class="container">
<div class="breadcrumb-1">
<ul>
 
<li>
<a href="shop-list-with-sidebar.php">Your Cart</a>
</li>
 
</ul>
</div>
</div>
</div>
</section>

<section>
    <div class="container mt-5">

        <?php if ($cart_empty): ?>
            <div class="alert alert-warning text-center" role="alert">
                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                <strong>No record found!</strong> Your cart is empty.
            </div>
            <div class="text-center mt-4">
                <a href="shop-list-without-sidebar.php" class="btn btn-primary btn-sm">
                    <i class="fa fa-shopping-cart"></i> Continue Shopping
                </a>
            </div>
        <?php else: ?>
            <form method="post" action="">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm cart-table">
                        <thead class="thead-dark">
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                                <tr>
                                    <td><img src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="cart-image"></td>
                                    <td><?php echo htmlspecialchars($item['title']); ?></td>
                                    <td>₹<?php echo htmlspecialchars($item['price']); ?></td>
                                    <td>
                                        <input type="number" name="quantity[<?php echo $id; ?>]" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1" class="form-control form-control-sm quantity-input">
                                    </td>
                                    <td>₹<?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                                    <td>
                                        <button type="submit" name="update_cart" class="btn btn-primary btn-sm mb-2">
                                            <i class="fa fa-refresh"></i> Update
                                        </button>
                                        <a href="?action=remove&id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Remove</a>
                                    </td>
                                    <?php $total += $item['price'] * $item['quantity']; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right font-weight-bold">Total</td>
                                <td colspan="2" class="font-weight-bold">₹<?php echo $total; ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="text-center mt-4">
                    <a href="checkout.php" class="btn btn-success btn-lg">
                        Proceed to Checkout
                    </a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</section>

<footer>
    <?php include 'Footer.php'; ?>
</footer>

<!-- Bootstrap and jQuery JS -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
