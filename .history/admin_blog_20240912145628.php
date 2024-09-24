<?php
include 'conn.php';
// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_blog'])) {
        // Handle Add Blog
        $title = $_POST['title'];
        $description = $_POST['description'];
        $image = $_FILES['image']['name'];
        $target = "images/" . basename($image);

        // Move uploaded image to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $sql = "INSERT INTO blogs (title, description, image) VALUES ('$title', '$description', '$image')";
            mysqli_query($conn, $sql);
        }
    } elseif (isset($_POST['update_blog'])) {
        // Handle Update Blog
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];

        // Check if a new image is uploaded
        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image']['name'];
            $target = "images/" . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
            $sql = "UPDATE blogs SET title='$title', description='$description', image='$image' WHERE id='$id'";
        } else {
            $sql = "UPDATE blogs SET title='$title', description='$description' WHERE id='$id'";
        }
        mysqli_query($conn, $sql);
    } elseif (isset($_POST['delete_blog'])) {
        // Handle Delete Blog
        $id = $_POST['id'];
        $sql = "DELETE FROM blogs WHERE id='$id'";
        mysqli_query($conn, $sql);
    }
}

// Fetch blog posts
$sql = "SELECT * FROM blogs ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Blog Management</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
        /* Add your custom styles here */
        .modal-content {
            padding: 20px;
            border-radius: 5px;
        }
        .modal-content img {
            max-width: 100%;
        }
        @media (max-width: 768px) {
            .modal-content {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<?php include 'Navbar.php'; ?>

<div class="container">
    <h1>Manage Blog Posts</h1>

    <!-- Form for Adding Blog Post -->
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" id="image" name="image" class="form-control">
        </div>
        <button type="submit" name="add_blog" class="btn btn-primary">Add Blog Post</button>
    </form>

    <!-- Display Existing Blog Posts -->
    <h2 class="mt-5">Existing Blog Posts</h2>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td>
                            <?php if ($row['image']): ?>
                                <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="Blog Image" style="width: 100px;">
                            <?php endif; ?>
                        </td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete_blog" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            <button class="btn btn-warning btn-sm" onclick="showUpdateForm(<?php echo $row['id']; ?>, '<?php echo addslashes($row['title']); ?>', '<?php echo addslashes($row['description']); ?>', '<?php echo addslashes($row['image']); ?>')">Update</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Update Blog Post Modal -->
<div id="updateModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Blog Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" id="update_id" name="id">
                    <div class="form-group">
                        <label for="update_title">Title</label>
                        <input type="text" id="update_title" name="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="update_description">Description</label>
                        <textarea id="update_description" name="description" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="update_image">Image</label>
                        <input type="file" id="update_image" name="image" class="form-control">
                        <img id="update_image_preview" style="width: 100%; max-width: 200px; margin-top: 10px;">
                    </div>
                    <button type="submit" name="update_blog" class="btn btn-primary">Update Blog Post</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function showUpdateForm(id, title, description, image) {
        document.getElementById('update_id').value = id;
        document.getElementById('update_title').value = title;
        document.getElementById('update_description').value = description;
        if (image) {
            document.getElementById('update_image_preview').src = 'images/' + image;
        }
        $('#updateModal').modal('show');
    }
</script>

</body>
</html>
