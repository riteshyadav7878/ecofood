<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include 'conn.php'; // Include your database connection file
include 'admin_Navbar.php';

// Handle slider actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle Add Slider
    if (isset($_POST['add_slider'])) {
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
            $target_dir = "uploads/slider/";
            $target_file = $target_dir . basename($_FILES["image_file"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if file is an actual image
            $check = getimagesize($_FILES["image_file"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "<div class='alert alert-danger'>File is not an image.</div>";
                $uploadOk = 0;
            }

            // Check file size (limit to 5MB)
            if ($_FILES["image_file"]["size"] > 5000000) {
                echo "<div class='alert alert-danger'>Sorry, your file is too large.</div>";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo "<div class='alert alert-danger'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "<div class='alert alert-danger'>Sorry, your file was not uploaded.</div>";
            } else {
                if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
                    $image_url = $target_file; // Save the file path in the database
                    $title = $conn->real_escape_string(trim($_POST['title']));
                    $description = $conn->real_escape_string(trim($_POST['description']));
                    
                    $sql = "INSERT INTO slider (image_url, title, description, status) VALUES ('$image_url', '$title', '$description', 'inactive')";
                    
                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='alert alert-success'>New slider added successfully.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
                }
            }
        } else {
            echo "<div class='alert alert-danger'>No file uploaded or there was an upload error.</div>";
        }
    }

    // Handle Update Slider
    if (isset($_POST['update_slider'])) {
        $slider_id = $conn->real_escape_string($_POST['slider_id']);
        $title = $conn->real_escape_string(trim($_POST['title']));
        $description = $conn->real_escape_string(trim($_POST['description']));

        // Check if a new file is uploaded
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
            $target_dir = "uploads/slider/";
            $target_file = $target_dir . basename($_FILES["image_file"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if file is an actual image
            $check = getimagesize($_FILES["image_file"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "<div class='alert alert-danger'>File is not an image.</div>";
                $uploadOk = 0;
            }

            // Check file size (limit to 5MB)
            if ($_FILES["image_file"]["size"] > 5000000) {
                echo "<div class='alert alert-danger'>Sorry, your file is too large.</div>";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo "<div class='alert alert-danger'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "<div class='alert alert-danger'>Sorry, your file was not uploaded.</div>";
            } else {
                if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
                    $image_url = $target_file;
                    $sql = "UPDATE slider SET image_url='$image_url', title='$title', description='$description' WHERE id=$slider_id";
                    
                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='alert alert-success'>Slider updated successfully.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
                }
            }
        } else {
            // Update slider details without changing the image
            $sql = "UPDATE slider SET title='$title', description='$description' WHERE id=$slider_id";
            
            if ($conn->query($sql) === TRUE) {
                echo "<div class='alert alert-success'>Slider updated successfully.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
            }
        }
    }

    // Handle Delete Slider
    if (isset($_POST['delete_slider'])) {
        $slider_id = $conn->real_escape_string($_POST['slider_id']);
        
        $sql = "DELETE FROM slider WHERE id=$slider_id";
        
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success'>Slider deleted successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
        }
    }

    // Handle Toggle Status
    if (isset($_POST['toggle_status'])) {
        $slider_id = $conn->real_escape_string($_POST['slider_id']);
        $current_status = $conn->real_escape_string($_POST['current_status']);
        $new_status = $current_status == 'active' ? 'inactive' : 'active';
        
        $sql = "UPDATE slider SET status='$new_status' WHERE id=$slider_id";
        
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success'>Slider status updated successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
        }
    }
}

// Fetch all sliders
$sql = "SELECT * FROM slider";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Slider Management</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9; /* Light background */
        }
        .container {
            margin-top: 20px;
        }
        h1 {
            color: #333; /* Darker color for header */
        }
        .table {
            background-color: #fff; /* White background for the table */
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .form-group label {
            color: #495057;
        }
        .form-control {
            border-radius: 0;
        }
        .alert {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container mb-5">
        <h1 class="mb-4 text-center">Manage Sliders</h1>
        
        <!-- Add Slider Form -->
        <div class="card mb-4">
            <div class="card-header">Add New Slider</div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="image_file">Image File:</label>
                        <input type="file" class="form-control-file" id="image_file" name="image_file" required>
                    </div>
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <button type="submit" name="add_slider" class="btn btn-primary">Add Slider</button>
                </form>
            </div>
        </div>

        <!-- Sliders Table -->
        <div class="card">
            <div class="card-header">Sliders List</div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><img src="<?php echo $row['image_url']; ?>" alt="Slider Image" class="img-thumbnail" width="100"></td>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo $row['description']; ?></td>
                                    <td>
                                        <form method="POST" style="display: inline-block;">
                                            <input type="hidden" name="slider_id" value="<?php echo $row['id']; ?>">
                                            <input type="hidden" name="current_status" value="<?php echo $row['status']; ?>">
                                            <button type="button" class="btn btn-warning btn-sm" onclick="editSlider(<?php echo $row['id']; ?>, '<?php echo $row['title']; ?>', '<?php echo $row['description']; ?>', '<?php echo $row['image_url']; ?>')">Edit</button>
                                            <button type="submit" name="delete_slider" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No sliders found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Slider Modal -->
    <div class="modal fade" id="editSliderModal" tabindex="-1" role="dialog" aria-labelledby="editSliderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSliderModalLabel">Edit Slider</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" id="editSliderForm">
                        <input type="hidden" name="slider_id" id="edit_slider_id">
                        <div class="form-group">
                            <label for="edit_title">Title:</label>
                            <input type="text" class="form-control" id="edit_title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Description:</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_image_file">Change Image (optional):</label>
                            <input type="file" class="form-control-file" id="edit_image_file" name="image_file">
                        </div>
                        <button type="submit" name="update_slider" class="btn btn-primary">Update Slider</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editSlider(id, title, description, imageUrl) {
            $('#edit_slider_id').val(id);
            $('#edit_title').val(title);
            $('#edit_description').val(description);
            $('#edit_image_file').val('');
            $('#editSliderModal').modal('show');
        }
    </script>
</body>
</html>
