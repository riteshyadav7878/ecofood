<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include your database connection file if needed
include 'conn.php';

// Check if the cart session exists and is not empty
$cart_empty = !isset($_SESSION['cart']) || empty($_SESSION['cart']);
$total = 0;
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <meta name="description" content="Ecofood theme template">
    <meta name="author" content="AuCreative">
    <meta name="keywords" content="Ecofood theme template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS Links -->
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
    <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.png">
    <script src="js/modernizr-custom.js"></script>
    <style>
        body {
            background: linear-gradient(to right, #ffecd2, #fcb69f); /* Vibrant background colors */
        }
        .checkout-container {
            background: #fff4e6; /* Light color to contrast with the background */
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        h1, h3 {
            font-size: 1.5rem; /* Smaller font size */
        }
        .table {
            background: #ffe0b3;
            font-size: 1.875rem; /* Smaller font size */
        }
        .table th, .table td {
            padding: 0.5rem; /* Smaller padding */
        }
        .form-group label {
            font-size: 1.875rem; /* Smaller font size */
        }
        .form-control {
            font-size: 1.875rem; /* Smaller font size */
            height: calc(1.5em + 0.75rem + 2px); /* Smaller height */
            padding: 0.375rem 0.75rem; /* Smaller padding */
        }
        .btn-primary {
            background-color: #ff7f50;
            border-color: #ff7f50;
            font-size: 2.875rem; /* Smaller font size */
            padding: 0.5rem 1rem; /* Smaller button */
        }
        .btn-primary:hover {
            background-color: #ff6347;
            border-color: #ff6347;
        }
        /* Error styling for empty inputs */
        .error {
            border: 2px solid red;
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
                    <h3>Billing Details</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="section border-bottom-grey">
        <div class="container">
            <div class="breadcrumb-1">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="checkout.php">Check out</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <?php if ($cart_empty): ?>
        <div class="text-center mt-5">
            <h3 class="text-danger">No records found</h3>
        </div>
    <?php else: ?>
        <div class="checkout-container">
            <div class="row">
                <!-- Order Summary -->
                <div class="col-12 col-md-6">
                    <h3>Order Summary</h3>
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['title']); ?></td>
                                    <td>$<?php echo htmlspecialchars($item['price']); ?></td>
                                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                    <td>$<?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                                    <?php $total += $item['price'] * $item['quantity']; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right font-weight-bold">Total</td>
                                <td class="font-weight-bold">$<?php echo $total; ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Billing Details -->
                <div class="col-12 col-md-6">
                    <h3>Billing Details</h3>
                    <form action="process_checkout.php" method="POST" id="checkoutForm">
                        <div class="form-group">
                            <label for="fullName">Full Name</label>
                            <input type="text" class="form-control" id="fullName" name="fullName" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                        <div class="form-group">
                            <label for="zip">Zip Code</label>
                            <input type="text" class="form-control" id="zip" name="zip" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'Footer.php'; ?>

<!-- JavaScript Files -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vendor/retinajs/dist/retina.min.js"></script>
<script src="vendor/SmoothScroll/SmoothScroll.js"></script>
<script src="js/switcher-custom.js"></script>
<script src="js/main.js"></script>

<!-- Custom JavaScript for input validation -->
<script>
document.getElementById('checkoutForm').addEventListener('submit', function(event) {
    let isValid = true;
    const inputs = this.querySelectorAll('input[required], textarea[required]');

    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('error');  // Add error class to highlight empty fields
            isValid = false;
        } else {
            input.classList.remove('error');  // Remove error class if field is valid
        }
    });

    if (!isValid) {
        event.preventDefault(); // Prevent form submission if there are errors
    }
});
</script>

</body>
</html>
