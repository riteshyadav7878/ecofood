<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin Panel</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .wrapper {
            display: flex;
            width: 100%;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            font-size: 16px;
        }
        .sidebar a:hover {
            background-color: #495057;
            text-decoration: none;
        }
        .sidebar a.active {
            background-color: #007bff;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
 
    <!-- Sidebar -->
    <nav class="sidebar">
        <a href="admin_index.php" class="active">
            <i class="fa fa-home"></i> Home
        </a>
        <a href="admin_register.php">
            <i class="fa fa-user-plus"></i> Admin Register
        </a>
        <a href="admin_login.php">
            <i class="fa fa-sign-in"></i> Login
        </a>
        <a href="admin_slider.php">
            <i class="fa fa-sliders"></i> Manage Slider
        </a>
        <a href="admin_users.php">
            <i class="fa fa-users"></i> Manage Users
        </a>
        <a href="admin_products.php">
            <i class="fa fa-shopping-bag"></i> Manage Products
        </a>
        <a href="admin_contact.php">
            <i class="fa fa-envelope"></i> Contact Check
        </a>
        <a href="admin_change_password.php">
            <i class="fa fa-key"></i> Change Password
        </a>
        <a href="admin_logout.php">
            <i class="fa fa-sign-out"></i> Logout
        </a>
    </nav>

    <!-- Page Content -->
 

<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
