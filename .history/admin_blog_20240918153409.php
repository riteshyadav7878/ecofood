<?php
session_start(); // Start the session

// Include database connection
include('conn.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php"); // Redirect to login page if not logged in
    exit();
}

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog List</title>
    <meta name="description" content="Ecofood theme tempalte">
    <meta name="author" content="AuCreative">
    <meta name="keywords" content="Ecofood theme template">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="fonts/fonts.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/css-hamburgers/dist/hamburgers.min.css" rel="stylesheet">
    <link href="vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css" rel="stylesheet">
    <link href="vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="vendor/revolution/css/layers.css" rel="stylesheet">
    <link href="vendor/revolution/css/navigation.css" rel="stylesheet">
    <link href="vendor/revolution/css/settings.css" rel="stylesheet">
    <link href="vendor/owl.carousel/dist/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/switcher.css" rel="stylesheet">
    <link href="css/colors/green.css" rel="stylesheet" id="colors">
    <link href="css/retina.css" rel="stylesheet">

    <link rel="shortcut icon" href="favicon.png">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.html">
    <script src="js/modernizr-custom.js"></script>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
        .modal-content {
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .modal-content img {
            max-width: 200px;
            display: block;
            margin-top: 10px;
        }

        #updateModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            width: 90%;
            max-width: 600px;
            margin: auto;
        }

        @media (max-width: 768px) {
            .modal-content {
                padding: 10px;
            }
        }

        /* Highlight invalid inputs */
        input:invalid,
        textarea:invalid {
            border: 2px solid red;
        }
    </style>
</head>

<body>

    <?php include 'admin_Navbar.php'; ?>
    <div class="container">
        <h1 class="my-4 text-center">Manage Blog Posts</h1>

        <!-- Form for Adding Blog Post -->
        <form method="post" enctype="multipart/form-data" class="mb-4" onsubmit="return validateAddForm()">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" class="form-control">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" id="image" name="image" class="form-control">
            </div>
            <button type="submit" name="add_blog" class="btn btn-primary">Add Blog Post</button>
        </form>

        <!-- Display Existing Blog Posts in a Table -->
        <h2 class="text-center">Existing Blog Posts</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
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
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php $srno ++; ?></td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td>
                                <?php if ($row['image']): ?>
                                    <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="Blog Image" class="img-fluid" style="max-width: 100px;">
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
    <div id="updateModal">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" onsubmit="return validateUpdateForm()">
                <input type="hidden" id="update_id" name="id">
                <div class="form-group">
                    <label for="update_title">Title</label>
                    <input type="text" id="update_title" name="title" class="form-control">
                </div>
                <div class="form-group">
                    <label for="update_description">Description</label>
                    <textarea id="update_description" name="description" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label for="update_image">Image</label>
                    <input type="file" id="update_image" name="image" class="form-control">
                    <img id="update_image_preview" class="img-fluid" style="max-width: 200px; margin-top: 10px;">
                </div>
                <button type="submit" name="update_blog" class="btn btn-primary">Update Blog Post</button>
                <button type="button" onclick="closeUpdateForm()" class="btn btn-secondary">Cancel</button>
            </form>
        </div>
    </div>

    <?php include 'admin_Footer.php'; ?>

    <!-- JavaScript for form validation and modal handling -->
    <script>
        // Validation for Add Blog Post Form
        function validateAddForm() {
            var title = document.getElementById("title");
            var description = document.getElementById("description");
            var image = document.getElementById("image");

            var isValid = true;

            // Clear previous error messages
            clearErrors(["titleError", "descriptionError", "imageError"]);

            // Reset styles
            title.style.border = "";
            description.style.border = "";
            image.style.border = "";

            if (title.value.trim() === "") {
                title.style.border = "2px solid red";
                showError("titleError", "Title is required", title);
                isValid = false;
            }

            if (description.value.trim() === "") {
                description.style.border = "2px solid red";
                showError("descriptionError", "Description is required", description);
                isValid = false;
            }

            if (image.value === "") {
                image.style.border = "2px solid red";
                showError("imageError", "Image is required", image);
                isValid = false;
            }

            return isValid; // Only submit if the form is valid
        }

        // Validation for Update Blog Post Form
        function validateUpdateForm() {
            var title = document.getElementById("update_title");
            var description = document.getElementById("update_description");

            var isValid = true;

            // Clear previous error messages
            clearErrors(["updateTitleError", "updateDescriptionError"]);

            // Reset styles
            title.style.border = "";
            description.style.border = "";

            if (title.value.trim() === "") {
                title.style.border = "2px solid red";
                showError("updateTitleError", "Title is required", title);
                isValid = false;
            }

            if (description.value.trim() === "") {
                description.style.border = "2px solid red";
                showError("updateDescriptionError", "Description is required", description);
                isValid = false;
            }

            return isValid; // Only submit if the form is valid
        }

        // Function to show error message
        function showError(id, message, element) {
            var errorElement = document.createElement("div");
            errorElement.id = id;
            errorElement.style.color = "red";
            errorElement.style.fontSize = "12px";
            errorElement.innerText = message;
            element.parentNode.insertBefore(errorElement, element.nextSibling);
        }

        // Function to clear error messages
        function clearErrors(ids) {
            ids.forEach(function(id) {
                var errorElement = document.getElementById(id);
                if (errorElement) {
                    errorElement.remove();
                }
            });
        }

        // Show Update Modal and Pre-fill Fields
        function showUpdateForm(id, title, description, image) {
            document.getElementById('update_id').value = id;
            document.getElementById('update_title').value = title;
            document.getElementById('update_description').value = description;
            if (image) {
                document.getElementById('update_image_preview').src = 'images/' + image;
            } else {
                document.getElementById('update_image_preview').src = '';
            }
            document.getElementById('updateModal').style.display = 'flex';
        }

        // Close Update Modal
        function closeUpdateForm() {
            document.getElementById('updateModal').style.display = 'none';
        }
    </script>
    <script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>