<?php
// Include the database connection
include 'conn.php';

// Initialize variables
$selected_user_id = null;
$username = null;

// Check if a user ID is selected
if (isset($_POST['user_id']) && is_numeric($_POST['user_id'])) {
    $selected_user_id = intval($_POST['user_id']);
}

// Fetch all users
$sql_users = "SELECT id, username FROM user ORDER BY username";
$user_result = $conn->query($sql_users);

// Fetch orders for the selected user if a user ID is selected
if ($selected_user_id) {
    $sql_orders = "SELECT o.*, u.username, u.email AS user_email 
                   FROM cart_order o 
                   JOIN user u ON o.user_id = u.id
                   WHERE o.user_id = ? 
                   ORDER BY o.order_date DESC";
    $stmt = $conn->prepare($sql_orders);
    $stmt->bind_param("i", $selected_user_id);
    $stmt->execute();
    $order_result = $stmt->get_result();
    
    // Fetch the username for the selected user
    $sql_username = "SELECT username FROM user WHERE id = ?";
    $stmt_username = $conn->prepare($sql_username);
    $stmt_username->bind_param("i", $selected_user_id);
    $stmt_username->execute();
    $result_username = $stmt_username->get_result();
    if ($user_row = $result_username->fetch_assoc()) {
        $username = $user_row['username'];
    }
} else {
    $order_result = null;
}

// Fetch the total number of users who have placed orders
$sql_users_count = "SELECT COUNT(DISTINCT user_id) AS user_count FROM cart_order";
$result_users_count = $conn->query($sql_users_count);
$user_count = $result_users_count->fetch_assoc()['user_count'];

// Close the statements and connection
if (isset($stmt)) {
    $stmt->close();
}
if (isset($stmt_username)) {
    $stmt_username->close();
}
$result_users_count->free();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Details</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Light background for the page */
        }
        .table-container {
            margin: 20px auto;
            max-width: 1200px;
        }
        .form-control {
            border-color: #007bff;
        }
        .form-control:focus {
            border-color: #0056b3;
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
        }
        .table {
            margin-top: 20px;
        }
        .table thead th {
            background-color: #007bff;
            color: #ffffff;
        }
        .table tbody tr:nth-child(odd) {
            background-color: #f1f1f1; /* Alternating row color */
        }
        .table tbody tr:hover {
            background-color: #e9ecef; /* Row hover color */
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }
        .btn-info:hover {
            background-color: #138496;
            border-color: #117a8b;
        }
    </style>
</head>
<body>
<?php include 'admin_Navbar.php'; ?>
    <div class="container table-container">
        <h1 class="text-center mb-4">Billing Details</h1>
        
        <p class="text-center mb-4"><strong>Total Users Who Have Placed Orders:</strong> <?php echo $user_count; ?></p>

        <!-- Form to select a user -->
        <form method="post" class="text-center mb-4">
            <div class="form-group">
                <label for="user_id">Select User:</label>
                <select id="user_id" name="user_id" class="form-control d-inline-block" style="width: auto;">
                    <option value="">--Select User--</option>
                    <?php while ($row = $user_result->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id']; ?>" <?php if ($selected_user_id == $row['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($row['username']); ?>
                        </option>
                    <?php } ?>
                </select>
                <button type="submit" class="btn btn-primary ml-2">View Orders</button>
            </div>
        </form>

        <?php if ($selected_user_id && $order_result && $order_result->num_rows > 0) { ?>
            <h2 class="text-center mb-4">Orders for <?php echo htmlspecialchars($username); ?></h2>
            
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Username</th>
                        <th>User Email</th>
                        <th>Full Name</th>
                        <th>Total Amount</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $order_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['order_id']; ?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_email']); ?></td>
                            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                            <td>$<?php echo number_format($row['total'], 2); ?></td>
                            <td><?php echo date("d-m-Y H:i", strtotime($row['order_date'])); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td>
                                <a href="order_details.php?order_id=<?php echo $row['order_id']; ?>" class="btn btn-info btn-sm">View Details</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } elseif ($selected_user_id) { ?>
            <p class="text-center text-danger">No orders found for this user.</p>
        <?php } ?>
    </div>


    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage - Ecofood HTML5 Template</title>
    <meta name="description" content="Ecofood theme template">
    <meta name="author" content="AuCreative">
    <meta name="keywords" content="Ecofood theme template">

    <!-- Stylesheets -->
    <link href="fonts/fonts.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/css-hamburgers/dist/hamburgers.min.css" rel="stylesheet">
    <link href="vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css" rel="stylesheet">
    <link href="vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="vendor/revolution/css/layers.css" rel="stylesheet">
    <link href="vendor/revolution/css/navigation.css" rel="stylesheet">
    <link href="vendor/revolution/css/settings.css" rel="stylesheet">
    <link href="vendor/owl.carousel/dist/assets/owl.carousel.min.css" rel="stylesheet">
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
        /* Ensure smooth scrolling and avoid jittering */
        html {
            scroll-behavior: smooth;
        }
        body {
            overflow-x: hidden; /* Prevent horizontal scroll */
        }
    </style>
</head>
<body>
    <header>
        <div class="section dark-background">
            <div class="container">
                <div class="header-2">
                    <div class="header-left">
                        <p>
                            <i class="fa fa-map-marker"></i>256 Address Name, New York city
                            <span>|</span>
                            <i class="fa fa-clock-o"></i>07:30 AM - 11:00 PM
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <nav>
        <div class="section white-background" id="js-navbar">
            <div class="container">
                <div class="nav-1 nav-2">
                    <button class="hamburger has-animation hamburger--collapse" id="toggle-icon">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                    <div class="logo">
                        <a href="index.php">
                            <img src="images/icons/ic-logo-01.png" alt="Ecofood">
                        </a>
                    </div>
                    <div class="cart-icon-holder">
                        <div class="cart-shopping js-mini-shopcart">
                            <span class="totals">2</span>
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                    </div>
                    <ul class="nav-menu">
                        <li><a class="has-text-color-hover" href="admin_index.php">HOME</a></li>
                        <li><a class="has-text-color-hover" href="admin_register.php">Admin Register</a></li>
                        <li class="has-drop">
                            <a class="has-text-color-hover" href="oo.php">Order Details</a>
                            <button class="btn-caret fa fa-angle-right"></button>
                        </li>
                        <li class="has-drop">
                            <a class="has-text-color-hover" href="admin_slider.php">Manage Slider</a>
                            <button class="btn-caret fa fa-angle-right"></button>
                        </li>
                        <li class="has-drop">
                            <a class="has-text-color-hover" href="admin_users.php">Manage Users</a>
                            <button class="btn-caret fa fa-angle-right"></button>
                        </li>
                        <li class="has-drop">
                            <a class="has-text-color-hover" href="admin_products.php">Manage Product</a>
                            <button class="btn-caret fa fa-angle-right"></button>
                        </li>
                        <li><a class="has-text-color-hover" href="admin_contact.php">Contact Check</a></li>
                        <li><a class="has-text-color-hover" href="admin_change_password.php">Change Password</a></li>
                        <li><a class="has-text-color-hover" href="admin_logout.php">Logout</a></li>
                    </ul>
                    <div class="mini-shopcart">
                        <div class="head-mini-shopcart">
                            <p>2 items in your cart</p>
                        </div>
                        <div class="content-mini-shopcart">
                            <div class="item-mini-shopcart">
                                <div class="item-image">
                                    <img src="images/shopping-cart-item-01.jpg" alt="shopping cart">
                                </div>
                                <div class="item-content">
                                    <h3 class="name">Strawberries, 16 oz</h3>
                                    <p class="price">1 x $2.50</p>
                                    <button class="btn-del fa fa-close"></button>
                                </div>
                            </div>
                            <div class="item-mini-shopcart">
                                <div class="item-image">
                                    <img src="images/shopping-cart-item-02.jpg" alt="shopping cart">
                                </div>
                                <div class="item-content">
                                    <h3 class="name">Broccoli, bunch</h3>
                                    <p class="price">2 x $4.00</p>
                                    <button class="btn-del fa fa-close"></button>
                                </div>
                            </div>
                        </div>
                        <div class="foot-mini-shopcart">
                            <p class="total-shopcart">Total: $6.50</p>
                            <div class="mini-shopcart-action">
                                <button class="au-btn au-btn-border au-btn-radius btn-viewcart">VIEW CART</button>
                                <button class="au-btn au-btn-primary au-btn-radius btn-checkout">CHECK OUT</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendor/retinajs/dist/retina.min.js"></script>
    <script src="vendor/SmoothScroll/SmoothScroll.js"></script>
    <script src="js/switcher-custom.js"></script>
    <script src="vendor/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script src="vendor/revolution/js/jquery.themepunch.revolution.min.js"></script>
    <script src="vendor/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="vendor/revolution/js/extensions/revolution.extension.video.min.js"></script>
    <script src="vendor/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
    <script src="vendor/revolution/js/extensions/revolution.extension.actions.min.js"></script>
    <script src="vendor/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
    <script src="vendor/revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
    <script src="vendor/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
    <script src="vendor/revolution/js/extensions/revolution.extension.migration.min.js"></script>
    <script src="vendor/revolution/js/extensions/revolution.extension.parallax.min.js"></script>
    <script src="js/revo-slider-custom.js"></script>
    <script src="js/owl-custom.js"></script>
    <script src="js/main.js"></script>
</body>
</html>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
