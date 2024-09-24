<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php"); // Redirect to login page if not logged in
    exit();
}

include 'conn.php'; // Include database connection

// Handle form submissions
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

    if (isset($_POST['toggle_status'])) {
        $user_id = intval($_POST['user_id']);

        // Fetch the current status
        $sql = "SELECT is_active FROM user WHERE id = $user_id";
        $result = $conn->query($sql);

        if ($result) {
            $user = $result->fetch_assoc();
            $new_status = isset($user['is_active']) ? ($user['is_active'] ? 0 : 1) : 0; // Toggle status

            // SQL query to update user status
            $sql = "UPDATE user SET is_active = $new_status WHERE id = $user_id";
            if ($conn->query($sql) === TRUE) {
                $_SESSION['message'] = 'User status updated successfully';
            } else {
                $_SESSION['message'] = 'Error: ' . $conn->error;
            }
        } else {
            $_SESSION['message'] = 'Error fetching user status: ' . $conn->error;
        }
        header("Location: admin_users.php"); // Redirect to avoid form resubmission
        exit();
    }
}

// Handle user update
if (isset($_GET['edit_user_id']) && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_user'])) {
    $user_id = intval($_GET['edit_user_id']);
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $receive_email_updates = isset($_POST['receive_email_updates']) ? 1 : 0;

    // Update user details
    $sql = "UPDATE user SET username='$username', email='$email', receive_email_updates=$receive_email_updates WHERE id=$user_id";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = 'User updated successfully';
        header("Location: admin_users.php");
        exit();
    } else {
        $_SESSION['message'] = 'Error: ' . $conn->error;
    }
}

// Fetch users
$sql = "SELECT * FROM user";
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

        <?php if (isset($_GET['edit_user_id'])) { ?>
            <!-- Edit User Form -->
            <?php
            // Fetch user details for the form
            $edit_user_id = intval($_GET['edit_user_id']);
            $sql = "SELECT * FROM user WHERE id = $edit_user_id";
            $result = $conn->query($sql);
            $user = $result->fetch_assoc();
            ?>
            <h2>Edit User</h2>
            <form action="admin_users.php?edit_user_id=<?php echo $edit_user_id; ?>" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="receive_email_updates" name="receive_email_updates" <?php echo $user['receive_email_updates'] ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="receive_email_updates">Receive Email Updates</label>
                </div>
                <button type="submit" name="update_user" class="btn btn-primary">Update User</button>
                <a href="admin_users.php" class="btn btn-secondary">Cancel</a>
            </form>
        <?php } else { ?>
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
                        while ($user = $result->fetch_assoc()) {
                            $status = isset($user['is_active']) ? ($user['is_active'] ? 'Active' : 'Inactive') : 'Unknown';
                            $status_class = isset($user['is_active']) ? ($user['is_active'] ? 'status-active' : 'status-inactive') : 'status-inactive';
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
                                        <a href='admin_users.php?edit_user_id={$user['id']}' class='btn btn-warning btn-custom'>Edit</a>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No users found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php } ?>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap Bundle with Popper (Bootstrap's JavaScript) -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include 'admin_Footer.php'; ?>
