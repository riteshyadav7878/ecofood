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

        if ($new_image) {
            move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $new_image);
            $stmt = $conn->prepare("UPDATE blog_posts SET title = ?, description = ?, image = ? WHERE id = ?");
            $stmt->bind_param("sssi", $title, $description, $new_image, $id);
        } else {
            $stmt = $conn->prepare("UPDATE blog_posts SET title = ?, description = ?, image = ? WHERE id = ?");
            $stmt->bind_param("sssi", $title, $description, $current_image, $id);
        }

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

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel">Update Blog Post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" enctype="multipart/form-data" id="updateForm">
            <input type="hidden" name="id" id="post-id">
            <input type="hidden" name="current_image" id="post-current-image">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="post-title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="post-description" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="post-image" class="form-control">
                <img id="post-image-preview" width="100">
            </div>
            <button type="submit" name="update_post" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    // Populate the modal with the selected post's data
    $('.update-btn').click(function() {
        var id = $(this).data('id');
        var title = $(this).data('title');
        var description = $(this).data('description');
        var image = $(this).data('image');

        $('#post-id').val(id);
        $('#post-title').val(title);
        $('#post-description').val(description);
        $('#post-current-image').val(image);

        // Show the current image in the preview
        if (image) {
            $('#post-image-preview').attr('src', 'images/' + image).show();
        } else {
            $('#post-image-preview').hide();
        }
    });
</script>

</body>
</html>
