<?php
session_start();
include 'conn.php';

// Handle Add, Update, and Delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Add a new post
    if (isset($_POST['add_post'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $image = $_FILES['image']['name'];

        if ($image) {
            move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $image);
        }

        $stmt = $conn->prepare("INSERT INTO blog_posts (title, description, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $description, $image);
        $stmt->execute();
    }

    // Update a post
    if (isset($_POST['update_post'])) {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $current_image = $_POST['current_image'];  
        $new_image = $_FILES['image']['name'];

        // Prepare the update query
        $query = "UPDATE blog_posts SET ";
        $params = [];
        $types = "";

        if (!empty($title)) {
            $query .= "title = ?, ";
            $params[] = $title;
            $types .= "s";
        }

        if (!empty($description)) {
            $query .= "description = ?, ";
            $params[] = $description;
            $types .= "s";
        }

        if ($new_image) {
            $query .= "image = ? ";
            $params[] = $new_image;
            $types .= "s";
            // Move the new image to the images directory
            move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $new_image);
        } else {
            $query .= "image = ? ";
            $params[] = $current_image;
            $types .= "s";
        }

        // Finalize the query
        $query .= "WHERE id = ?";
        $params[] = $id;
        $types .= "i";

        // Prepare and execute the statement
        $stmt = $conn->prepare($query);
        $stmt->bind_param($types, ...$params);
        
        if ($stmt->execute()) {
            echo '<script>alert("Post updated successfully.");</script>';
        } else {
            echo '<script>alert("Error updating post.");</script>';
        }
    }

    // Delete a post
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .edit-input {
            margin-bottom: 5px;
            width: 100%;
        }
        .edit-form {
            display: inline-block;
            margin-right: 10px;
        }
        #post-image-preview {
            margin-top: 10px;
        }
    </style>
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
    <h2 class="mt-4">Existing Blog Posts</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td>
                    <?php if ($row['image']): ?>
                        <img src="images/<?php echo htmlspecialchars($row['image']); ?>" width="100">
                    <?php else: ?>
                        No Image
                    <?php endif; ?>
                </td>
                <td>
                    <!-- Update button -->
                    <button class="btn btn-primary update-btn" data-toggle="modal" data-target="#updateModal" 
                            data-id="<?php echo $row['id']; ?>" 
                            data-title="<?php echo htmlspecialchars($row['title']); ?>" 
                            data-description="<?php echo htmlspecialchars($row['description']); ?>" 
                            data-image="<?php echo htmlspecialchars($row['image']); ?>">Update</button>

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
