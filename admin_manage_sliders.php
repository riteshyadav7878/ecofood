<?php
session_start(); // Start the session

// Include database connection
include('conn.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php"); // Redirect to login page if not logged in
    exit();
}
// Handle form submission for adding a new slider
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_slider'])) {
        $title = $conn->real_escape_string(trim($_POST['title']));
        $description = $conn->real_escape_string(trim($_POST['description']));
        $status = $conn->real_escape_string(trim($_POST['status']));

        // Handle file upload
        $image = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $upload_dir = 'uploads/';
            $image = basename($_FILES['image']['name']);
            $upload_file = $upload_dir . $image;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
                // File upload success
            } else {
                echo "Failed to upload image.";
            }
        }

        $sql = "INSERT INTO sliders (image, title, description, status) VALUES ('$image', '$title', '$description', '$status')";

        if ($conn->query($sql) === TRUE) {
            echo "New slider added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Fetch sliders for listing
$sql = "SELECT * FROM sliders";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Sliders</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Manage Sliders</h1>

        <!-- Add Slider Form -->
        <form action="admin_manage_sliders.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <button type="submit" name="add_slider" class="btn btn-primary">Add Slider</button>
        </form>

        <h2>Existing Sliders</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td><img src='uploads/{$row['image']}' alt='{$row['title']}' width='100'></td>
                            <td>{$row['title']}</td>
                            <td>{$row['description']}</td>
                            <td>{$row['status']}</td>
                            <td>
                                <a href='admin_edit_slider.php?id={$row['id']}' class='btn btn-warning'>Edit</a>
                                <a href='admin_delete_slider.php?id={$row['id']}' class='btn btn-danger'>Delete</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No sliders found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php
$conn->close();
?>