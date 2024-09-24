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
        /* Custom styles for table */
        .table img {
            width: 100px; /* Increase image size */
        }
        .table td {
            vertical-align: middle; /* Center align content vertically */
        }
        .table td img {
            display: block;
            margin-left: auto;
            margin-right: auto; /* Center align image horizontally */
        }
        .table td.quantity-col {
            width: 10%; /* Adjust column size */
        }
        .table td.action-col {
            width: 20%; /* Adjust column size */
        }
        @media (max-width: 768px) {
            .table td {
                font-size: 14px;
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
                <table class="table table-bordered table-responsive">
                    <thead class="thead-dark">
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th class="quantity-col">Quantity</th>
                            <th>Total</th>
                            <th class="action-col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                            <tr>
                                <td class="text-center">
                                    <img src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                                </td>
                                <td><?php echo htmlspecialchars($item['title']); ?></td>
                                <td>₹<?php echo htmlspecialchars($item['price']); ?></td>
                                <td class="quantity-col">
                                    <input type="number" name="quantity[<?php echo $id; ?>]" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1" class="form-control form-control-sm">
                                </td>
                                <td>₹<?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                                <td class="action-col">
                                    <a href="?action=remove&id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Remove</a>
                                    <button type="submit" name="update_cart" class="btn btn-warning btn-sm mt-2">Update</button>
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
