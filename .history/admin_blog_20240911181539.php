<?php
session_start();

include 'conn.php';

// Handle form submission for updating blog posts
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_blog'])) {
        $blog_id = mysqli_real_escape_string($conn, $_POST['blog_id']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);

        // Handle image upload
        if ($_FILES['image']['error'] == 0) {
            $image_name = $_FILES['image']['name'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_path = 'uploads/' . $image_name;

            if (move_uploaded_file($image_tmp_name, $image_path)) {
                $sql = "UPDATE blogs SET title='$title', content='$content', image='$image_name' WHERE id='$blog_id'";
            } else {
                $error = "Image upload failed.";
            }
        } else {
            $sql = "UPDATE blogs SET title='$title', content='$content' WHERE id='$blog_id'";
        }

        if (!isset($error)) {
            if (mysqli_query($conn, $sql)) {
                $success = "Blog updated successfully.";
            } else {
                $error = "Database update failed.";
            }
        }
    }
}

// Handle delete request
if (isset($_GET['delete_blog'])) {
    $blog_id = mysqli_real_escape_string($conn, $_GET['delete_blog']);
    
    // Fetch the blog post to get the image path
    $sql = "SELECT image FROM blogs WHERE id='$blog_id'";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $image_path = 'uploads/' . $row['image'];
        if (file_exists($image_path)) {
            unlink($image_path); // Delete the image file
        }
    }

    // Delete the blog post from the database
    $sql = "DELETE FROM blogs WHERE id='$blog_id'";
    if (mysqli_query($conn, $sql)) {
        $success = "Blog deleted successfully.";
    } else {
        $error = "Failed to delete blog.";
    }
}

// Fetch blog posts from the database
$sql = "SELECT * FROM blogs ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Blog - Manage Blog Posts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
        /* Add some custom styles here */
    </style>
</head>
<body>
    

    <div class="container">
        <h1>Manage Blog Posts</h1>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" width="100"></td>
                        <td>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-id="<?php echo htmlspecialchars($row['id']); ?>" data-title="<?php echo htmlspecialchars($row['title']); ?>" data-content="<?php echo htmlspecialchars($row['content']); ?>" data-image="<?php echo htmlspecialchars($row['image']); ?>">Edit</button>
                            <a href="?delete_blog=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this blog post?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Blog Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="blog_id" id="blog_id">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control" name="content" id="content" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control-file" name="image" id="image">
                        </div>
                        <div class="form-group">
                            <img id="preview-image" src="" alt="" style="max-width: 100%; display: none;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="update_blog">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var blogId = button.data('id');
            var title = button.data('title');
            var content = button.data('content');
            var image = button.data('image');

            var modal = $(this);
            modal.find('#blog_id').val(blogId);
            modal.find('#title').val(title);
            modal.find('#content').text(content);
            modal.find('#preview-image').attr('src', 'uploads/' + image).show();
        });
    </script>
</body>
</html>
<?php
session_start();

include 'conn.php';

// Handle form submission for updating blog posts
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_blog'])) {
        $blog_id = mysqli_real_escape_string($conn, $_POST['blog_id']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);

        // Handle image upload
        if ($_FILES['image']['error'] == 0) {
            $image_name = $_FILES['image']['name'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_path = 'uploads/' . $image_name;

            if (move_uploaded_file($image_tmp_name, $image_path)) {
                $sql = "UPDATE blogs SET title='$title', content='$content', image='$image_name' WHERE id='$blog_id'";
            } else {
                $error = "Image upload failed.";
            }
        } else {
            $sql = "UPDATE blogs SET title='$title', content='$content' WHERE id='$blog_id'";
        }

        if (!isset($error)) {
            if (mysqli_query($conn, $sql)) {
                $success = "Blog updated successfully.";
            } else {
                $error = "Database update failed.";
            }
        }
    }
}

// Handle delete request
if (isset($_GET['delete_blog'])) {
    $blog_id = mysqli_real_escape_string($conn, $_GET['delete_blog']);
    
    // Fetch the blog post to get the image path
    $sql = "SELECT image FROM blogs WHERE id='$blog_id'";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $image_path = 'uploads/' . $row['image'];
        if (file_exists($image_path)) {
            unlink($image_path); // Delete the image file
        }
    }

    // Delete the blog post from the database
    $sql = "DELETE FROM blogs WHERE id='$blog_id'";
    if (mysqli_query($conn, $sql)) {
        $success = "Blog deleted successfully.";
    } else {
        $error = "Failed to delete blog.";
    }
}

// Fetch blog posts from the database
$sql = "SELECT * FROM blogs ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Blog - Manage Blog Posts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
        /* Add some custom styles here */
    </style>
</head>
<body>
    

    <div class="container">
        <h1>Manage Blog Posts</h1>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" width="100"></td>
                        <td>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-id="<?php echo htmlspecialchars($row['id']); ?>" data-title="<?php echo htmlspecialchars($row['title']); ?>" data-content="<?php echo htmlspecialchars($row['content']); ?>" data-image="<?php echo htmlspecialchars($row['image']); ?>">Edit</button>
                            <a href="?delete_blog=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this blog post?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Blog Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="blog_id" id="blog_id">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control" name="content" id="content" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control-file" name="image" id="image">
                        </div>
                        <div class="form-group">
                            <img id="preview-image" src="" alt="" style="max-width: 100%; display: none;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="update_blog">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var blogId = button.data('id');
            var title = button.data('title');
            var content = button.data('content');
            var image = button.data('image');

            var modal = $(this);
            modal.find('#blog_id').val(blogId);
            modal.find('#title').val(title);
            modal.find('#content').text(content);
            modal.find('#preview-image').attr('src', 'uploads/' + image).show();
        });
    </script>
</body>
</html>
<?php
session_start();

include 'conn.php';

// Handle form submission for updating blog posts
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_blog'])) {
        $blog_id = mysqli_real_escape_string($conn, $_POST['blog_id']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);

        // Handle image upload
        if ($_FILES['image']['error'] == 0) {
            $image_name = $_FILES['image']['name'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_path = 'uploads/' . $image_name;

            if (move_uploaded_file($image_tmp_name, $image_path)) {
                $sql = "UPDATE blogs SET title='$title', content='$content', image='$image_name' WHERE id='$blog_id'";
            } else {
                $error = "Image upload failed.";
            }
        } else {
            $sql = "UPDATE blogs SET title='$title', content='$content' WHERE id='$blog_id'";
        }

        if (!isset($error)) {
            if (mysqli_query($conn, $sql)) {
                $success = "Blog updated successfully.";
            } else {
                $error = "Database update failed.";
            }
        }
    }
}

// Handle delete request
if (isset($_GET['delete_blog'])) {
    $blog_id = mysqli_real_escape_string($conn, $_GET['delete_blog']);
    
    // Fetch the blog post to get the image path
    $sql = "SELECT image FROM blogs WHERE id='$blog_id'";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $image_path = 'uploads/' . $row['image'];
        if (file_exists($image_path)) {
            unlink($image_path); // Delete the image file
        }
    }

    // Delete the blog post from the database
    $sql = "DELETE FROM blogs WHERE id='$blog_id'";
    if (mysqli_query($conn, $sql)) {
        $success = "Blog deleted successfully.";
    } else {
        $error = "Failed to delete blog.";
    }
}

// Fetch blog posts from the database
$sql = "SELECT * FROM blogs ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Blog - Manage Blog Posts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
        /* Add some custom styles here */
    </style>
</head>
<body>
    

    <div class="container">
        <h1>Manage Blog Posts</h1>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" width="100"></td>
                        <td>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-id="<?php echo htmlspecialchars($row['id']); ?>" data-title="<?php echo htmlspecialchars($row['title']); ?>" data-content="<?php echo htmlspecialchars($row['content']); ?>" data-image="<?php echo htmlspecialchars($row['image']); ?>">Edit</button>
                            <a href="?delete_blog=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this blog post?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Blog Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="blog_id" id="blog_id">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control" name="content" id="content" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control-file" name="image" id="image">
                        </div>
                        <div class="form-group">
                            <img id="preview-image" src="" alt="" style="max-width: 100%; display: none;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="update_blog">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var blogId = button.data('id');
            var title = button.data('title');
            var content = button.data('content');
            var image = button.data('image');

            var modal = $(this);
            modal.find('#blog_id').val(blogId);
            modal.find('#title').val(title);
            modal.find('#content').text(content);
            modal.find('#preview-image').attr('src', 'uploads/' + image).show();
        });
    </script>
</body>
</html>
