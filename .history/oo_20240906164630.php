<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include your database connection file
include 'conn.php';

// Initialize variables
$order = null;
$itemsResult = null;

// Fetch order details
if (isset($_GET['order_id'])) {
    $orderId = intval($_GET['order_id']);

    // Fetch the order info
    $sql = "SELECT * FROM cart_order WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $orderResult = $stmt->get_result();
    $order = $orderResult->fetch_assoc();

    // Fetch the items in the order
    $sql = "SELECT * FROM order_cart WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $itemsResult = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Success</title>
    <meta name="description" content="Ecofood theme template">
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
    <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.png">
    <script src="js/modernizr-custom.js"></script>
    <style>
        .centered-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
        }
        .card-body p {
            margin-bottom: 0.5rem;
        }
        .table img {
            max-width: 150px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .table th, .table td {
            text-align: center;
        }
        .no-image {
            color: #777;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="page-loader">
        <div class="loader"></div>
    </div>
    <header>
        <div class="section dark-background">
            <div class="container">
                <div class="header-2">
                    <div class="header-left">
                        <p>
                            <i class="fa fa-map-marker"></i>256 Address Name, New York city
                            <span>|</span>
                            <i class="fa fa-clock-o"></i>07:30 Am - 11:00 Pm
                        </p>
                    </div>
                    <div class="header-right">
                        <a href="logout.php">
                            <i class="fa fa-user"></i>Logout
                        </a>
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
                        <h3>Order Details</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="section border-bottom-grey">
            <div class="container">
                <div class="breadcrumb-1">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="checkout.php">Order successfully</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <?php if ($order): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Order ID: <?php echo htmlspecialchars($order['order_id']); ?></h5>
                    <p class="card-text">Full Name: <?php echo htmlspecialchars($order['full_name']); ?></p>
                    <p class="card-text">Email: <?php echo htmlspecialchars($order['email']); ?></p>
                    <p class="card-text">Address: <?php echo htmlspecialchars($order['address']); ?></p>
                    <p class="card-text">City: <?php echo htmlspecialchars($order['city']); ?></p>
                    <p class="card-text">Zip Code: <?php echo htmlspecialchars($order['zip']); ?></p>
                    <p class="card-text">Total: $<?php echo htmlspecialchars(number_format($order['total'], 2)); ?></p>
                    <p class="card-text">Status: <?php echo htmlspecialchars($order['status']); ?></p>
                    <p class="card-text">Order Date: <?php echo htmlspecialchars($order['order_date']); ?></p>
                </div>
            </div>

            <h4>Order Items</h4>
            <?php if ($itemsResult->num_rows > 0): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($item = $itemsResult->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <?php if ($item['image']): ?>
                                        <img src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
                                    <?php else: ?>
                                        <p class="no-image">No image available</p>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                <td>$<?php echo htmlspecialchars(number_format($item['price'], 2)); ?></td>
                                <td>$<?php echo htmlspecialchars(number_format($item['total'], 2)); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No items found for this order.</p>
            <?php endif; ?>
        <?php else: ?>
            <p>Order not found.</p>
        <?php endif; ?>

        <a href="welcome.php" class="btn btn-primary">Continue Shopping</a>
    </div>

    <?php include 'Footer.php'; ?>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendor/retinajs/dist/retina.min.js"></script>
    <script src="vendor/SmoothScroll/SmoothScroll.js"></script>
    <script src="js/switcher-custom.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
