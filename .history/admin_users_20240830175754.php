<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php"); // Redirect to login page if not logged in
    exit();
}

include 'conn.php'; // Include database connection
 // Include navbar



// Handling form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_user'])) {
        $user_id = intval($_POST['user_id']);

        // SQL query to delete user
        $sql = "DELETE FROM users WHERE id = $user_id";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = 'User deleted successfully';
        } else {
            $_SESSION['message'] = 'Error: ' . $conn->error;
        }
        header("Location: admin_users.php"); // Redirect to avoid form resubmission
        exit();
    }

    if (isset($_POST['toggle_status'])) {
        $user_id = intval($_POST['user_id']);

        // Fetch the current status
        $sql = "SELECT is_active FROM users WHERE id = $user_id";
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();
        $new_status = $user['is_active'] ? 0 : 1; // Toggle status

        // SQL query to update user status
        $sql = "UPDATE users SET is_active = $new_status WHERE id = $user_id";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = 'User status updated successfully';
        } else {
            $_SESSION['message'] = 'Error: ' . $conn->error;
        }
        header("Location: admin_users.php"); // Redirect to avoid form resubmission
        exit();
    }
}

// Fetch users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// Close connection
$conn->close();
?>
<?php include 'admin_Navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Users</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .container { margin-top: 20px; }
        table { width: 100%; }
        .status-active { background-color: #28a745; color: white; }
        .status-inactive { background-color: #6c757d; color: white; }
        .btn-custom { margin-right: 5px; }
        .alert { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Manage Users</h1>
        <!-- Displaying messages -->
        <?php if (isset($_SESSION['message'])) { ?>
            <div class="alert alert-info"><?php echo $_SESSION['message']; ?></div>
            <?php unset($_SESSION['message']); ?>
        <?php } ?>
        <!-- Displaying users -->
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Receive Email Updates</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($user = $result->fetch_assoc()) {
                        $status = $user['is_active'] ? 'Active' : 'Inactive';
                        $status_class = $user['is_active'] ? 'status-active' : 'status-inactive';
                        echo "<tr>
                                <td>{$user['id']}</td>
                                <td>{$user['username']}</td>
                                <td>{$user['email']}</td>
                                <td>" . ($user['receive_email_updates'] ? 'Yes' : 'No') . "</td>
                                <td>
                                    <form action='admin_users.php' method='post' style='display:inline;'>
                                        <input type='hidden' name='user_id' value='{$user['id']}'>
                                        <button type='submit' name='toggle_status' class='btn btn-custom $status_class'>" . $status . "</button>
                                    </form>
                                </td>
                                <td>
                                    <!-- Form for deleting user -->
                                    <form action='admin_users.php' method='post' style='display:inline;'>
                                        <input type='hidden' name='user_id' value='{$user['id']}'>
                                        <button type='submit' name='delete_user' class='btn btn-danger btn-custom'>Delete</button>
                                    </form>
                                    <!-- Form for editing user -->
                                    <form action='edit_user.php' method='get' style='display:inline;'>
                                        <input type='hidden' name='user_id' value='{$user['id']}'>
                                        <button type='submit' class='btn btn-warning btn-custom'>Edit</button>
                                    </form>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap Bundle with Popper (Bootstrap's JavaScript) -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include 'admin_Footer.php'; ?>
