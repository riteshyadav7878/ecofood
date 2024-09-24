<?php
 
include 'conn.php';

 

// Handle Add, Edit, and Delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_post'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $image = $_FILES['image']['name'];

        // Move uploaded image to the images directory
        if ($image) {
            move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $image);
        }

        // Insert blog post into the database
        $stmt = $conn->prepare("INSERT INTO blog_posts (title, description, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $description, $image);
        $stmt->execute();
    }

    if (isset($_POST['edit_post'])) {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $image = $_FILES['image']['name'];

        // Update blog post with or without the image
        if ($image) {
            move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $image);
            $stmt = $conn->prepare("UPDATE blog_posts SET title = ?, description = ?, image = ? WHERE id = ?");
            $stmt->bind_param("sssi", $title, $description, $image, $id);
        } else {
            $stmt = $conn->prepare("UPDATE blog_posts SET title = ?, description = ? WHERE id = ?");
            $stmt->bind_param("ssi", $title, $description, $id);
        }
        $stmt->execute();
    }

    if (isset($_POST['delete_post'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM blog_posts WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}

// Fetch all blog posts
$result = $conn->query("SELECT * FROM blog_posts");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Blog Management</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1>Manage Blog Posts</h1>

    <!-- Add new blog post form -->
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" name="add_post" class="btn btn-success">Add Post</button>
    </form>

    <!-- Blog posts list -->
    <h2>Existing Blog Posts</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td><img src="images/<?php echo htmlspecialchars($row['image']); ?>" width="100"></td>
                <td>
                    <!-- Edit form -->
                    <form method="POST" enctype="multipart/form-data" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>
                        <textarea name="description" required><?php echo htmlspecialchars($row['description']); ?></textarea>
                        <input type="file" name="image">
                        <button type="submit" name="edit_post" class="btn btn-primary">Edit</button>
                    </form>

                    <!-- Delete form -->
                    <form method="POST" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete_post" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
