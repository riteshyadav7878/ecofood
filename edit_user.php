<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="my-4">Edit User</h1>
        <?php
        // Start session
        session_start();

        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'ecofood');

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get user ID
        $user_id = intval($_GET['user_id']);

        // Fetch user data
        $sql = "SELECT * FROM users WHERE id = $user_id";
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Update user data
            $username = $conn->real_escape_string(trim($_POST['username']));
            $email = $conn->real_escape_string(trim($_POST['email']));
            $receive_email_updates = isset($_POST['email-updates']) ? 1 : 0;

            $sql = "UPDATE users SET username='$username', email='$email', receive_email_updates=$receive_email_updates WHERE id=$user_id";

            if ($conn->query($sql) === TRUE) {
                echo "<div class='alert alert-success'>User updated successfully</div>";
                // Redirect to user management page
                header("Location: admin_users.php");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
            }
        }

        // Close connection
        $conn->close();
        ?>

        <form action="edit_user.php?user_id=<?php echo $user_id; ?>" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="email-updates" name="email-updates" <?php echo $user['receive_email_updates'] ? 'checked' : ''; ?>>
                <label class="form-check-label" for="email-updates">Receive email updates</label>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap Bundle with Popper (Bootstrap's JavaScript) -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>