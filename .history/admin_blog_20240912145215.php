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
            <textarea id="description" name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" id="image" name="image" class="form-control">
        </div>
        <button type="submit" name="add_blog" class="btn btn-primary">Add Blog Post</button>
    </form>

    <!-- Display Existing Blog Posts -->
    <h2>Existing Blog Posts</h2>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="blog-item">
            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
            <p><?php echo htmlspecialchars($row['description']); ?></p>
            <?php if ($row['image']): ?>
                <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="Blog Image" style="width: 200px;">
            <?php endif; ?>
            <form method="post" style="display:inline;">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <button type="submit" name="delete_blog" class="btn btn-danger">Delete</button>
            </form>
            <button class="btn btn-warning" onclick="showUpdateForm(<?php echo $row['id']; ?>, '<?php echo addslashes($row['title']); ?>', '<?php echo addslashes($row['description']); ?>', '<?php echo addslashes($row['image']); ?>')">Update</button>
        </div>
    <?php endwhile; ?>
</div>

<!-- Update Blog Post Modal -->
<div id="updateModal" style="display:none;">
    <div class="modal-content">
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" id="update_id" name="id">
            <div class="form-group">
                <label for="update_title">Title</label>
                <input type="text" id="update_title" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="update_description">Description</label>
                <textarea id="update_description" name="description" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="update_image">Image</label>
                <input type="file" id="update_image" name="image" class="form-control">
                <img id="update_image_preview" style="width: 200px;">
            </div>
            <button type="submit" name="update_blog" class="btn btn-primary">Update Blog Post</button>
            <button type="button" onclick="closeUpdateForm()" class="btn btn-secondary">Cancel</button>
        </form>
    </div>
</div>

<script>
    function showUpdateForm(id, title, description, image) {
        document.getElementById('update_id').value = id;
        document.getElementById('update_title').value = title;
        document.getElementById('update_description').value = description;
        if (image) {
            document.getElementById('update_image_preview').src = 'images/' + image;
        }
        document.getElementById('updateModal').style.display = 'block';
    }

    function closeUpdateForm() {
        document.getElementById('updateModal').style.display = 'none';
    }
</script>

</body>
</html>
