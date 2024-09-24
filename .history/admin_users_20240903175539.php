<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php"); // Redirect to login page if not logged in
    exit();
}

include 'conn.php'; // Include database connection

// Handling form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_user'])) {
    $user_id = intval($_POST['user_id']);
    $email = $conn->real_escape_string($_POST['email']);
    $surname = $conn->real_escape_string($_POST['surname']);

    // SQL query to update user details
    $sql = "UPDATE user SET email = '$email', surname = '$surname' WHERE id = $user_id";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = 'User updated successfully';
    } else {
        $_SESSION['message'] = 'Error: ' . $conn->error;
    }
    header("Location: admin_users.php"); // Redirect to avoid form resubmission
    exit();
}

// Fetch user details
$user_id = intval($_GET['user_id']);
$sql = "SELECT * FROM user WHERE id = $user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .container { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Edit User</h1>
        <!-- Displaying messages -->
        <?php if (isset($_SESSION['message'])) { ?>
            <div class="alert alert-info"><?php echo $_SESSION['message']; ?></div>
            <?php unset($_SESSION['message']); ?>
        <?php } ?>
        <!-- Edit user form -->
        <form action="edit_user.php" method="post">
            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="surname" class="form-label">Surname</label>
                <input type="text" class="form-control" id="surname" name="surname" value="<?php echo htmlspecialchars($user['surname']); ?>" required>
            </div>
            <button type="submit" name="update_user" class="btn btn-primary">Update</button>
        </form>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap Bundle with Popper (Bootstrap's JavaScript) -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
