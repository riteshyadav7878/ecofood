<?php
session_start(); // Start the session

// Include database connection
include('conn.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php"); // Redirect to login page if not logged in
    exit();
}

// Handling form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_user'])) {
        $user_id = intval($_POST['user_id']);

        // SQL query to delete user
        $sql = "DELETE FROM user WHERE id = $user_id";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = 'User deleted successfully';
        } else {
            $_SESSION['message'] = 'Error: ' . $conn->error;
        }
        header("Location: admin_users.php"); // Redirect to avoid form resubmission
        exit();
    }
}

// Fetch users without status information
$sql = "SELECT * FROM user ORDER BY id DESC";
$result = $conn->query($sql);
// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
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
    <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.html">
    <script src="js/modernizr-custom.js"></script>
    <!-- Bootstrap 5 CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .container {
            margin-top: 20px;
        }

        .btn-custom {
            margin-right: 5px;
        }

        .alert {
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <!-- Include Navbar -->
    <?php include 'admin_Navbar.php'; ?>

    <div class="container">
        <h1 class="my-4 text-center">Manage Users</h1>

        <!-- Displaying messages -->
        <?php if (isset($_SESSION['message'])) { ?>
            <div class="alert alert-info"><?php echo $_SESSION['message']; ?></div>
            <?php unset($_SESSION['message']); ?>
        <?php } ?>

        <!-- Responsive table -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
            <thead class="table-dark">
    <tr>
        <th>Sr no</th>
        <th>Username</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>
</thead>
<tbody>
    <?php
    $sr
    if ($result->num_rows > 0) {
        while ($user = $result->fetch_assoc()) {
            echo "<tr>
                <td><?= $srno++; ?></td>
                <td>{$user['username']}</td>
                <td>{$user['email']}</td>
                <td>
                    <!-- Form for deleting user -->
                    <form action='admin_users.php' method='post' style='display:inline;'>
                        <input type='hidden' name='user_id' value='{$user['id']}'>
                        <button type='submit' name='delete_user' class='btn btn-danger btn-custom'>Delete</button>
                    </form>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='4' class='text-center'>No users found</td></tr>";
    }
    ?>
</tbody>
            </table>
        </div>
    </div>

    <!-- jQuery for Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- Include Footer -->
    <?php include 'admin_Footer.php'; ?>

</body>

</html>