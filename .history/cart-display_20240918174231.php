<?php
session_name("user_session");
session_start();

// Check if the cart session exists and is not empty
$cart_empty = !isset($_SESSION['cart']) || empty($_SESSION['cart']);

// Calculate the total quantity of items in the cart
$total_quantity = $cart_empty ? 0 : array_sum(array_column($_SESSION['cart'], 'quantity'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Display</title>
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <style>
        /* Custom styles for cart icon */
        .cart-icon-holder {
            position: relative;
            display: inline-block;
        }

        .cart-item-count {
            position: absolute;
            top: -10px; /* Adjust this value as needed */
            right: -10px; /* Adjust this value as needed */
            background-color: red; /* Or any color you prefer */
            color: white;
            border-radius: 50%;
            width: 20px; /* Adjust size as needed */
            height: 20px; /* Adjust size as needed */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px; /* Adjust size as needed */
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Cart Icon -->
    <a href="cart.php">
        <div class="cart-icon-holder">
            <div class="cart-shopping js-mini-shopcart">
                <i class="fa fa-shopping-cart"></i>
                <?php if ($total_quantity > 0): ?>
                    <span class="cart-item-count"><?php echo $total_quantity; ?></span>
                <?php endif; ?>
            </div>
        </div>
    </a>

</body>
</html>
