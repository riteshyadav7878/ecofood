<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
include 'conn.php'; // Include your database connection file
include 'admin_Navbar.php';
// Check if admin is logged in

 

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
    if (isset($_POST['delete_slide'])) {
        $slider_id = $conn->real_escape_string($_POST['slide_id']);
        
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
            <div class="card-header bg-primary text-white">
                Add New Slider
            </div>
            <div class="card-body">
                <form action="admin_slider.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image_file">Image File:</label>
                        <input type="file" class="form-control-file" id="image_file" name="image_file" required>
                    </div>
                    <button type="submit" name="add_slider" class="btn btn-success mt-3">Add Slider</button>
                </form>
            </div>
        </div>

        <!-- Display Sliders -->
        <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr class="bg-secondary text-white">
                    <th>Image</th>
                    <th>Title</th>
                    <th>Description</th>
                  <!-- <th>Status</th> -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><img src="<?php echo $row['image_url']; ?>" alt="Slider Image" style="width: 150px;"></td>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td>
                        <?php echo $row['status'] == 'active' ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>'; ?>
                    </td>
                    <td>
                        <!-- Toggle Status -->
                        <form action="admin_slider.php" method="post" class="d-inline">
                            <input type="hidden" name="slider_id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="current_status" value="<?php echo $row['status']; ?>">
                            <button type="submit" name="toggle_status" class="btn btn-sm btn-info">
                                <?php echo $row['status'] == 'active' ? 'Deactivate' : 'Activate'; ?>
                            </button>
                        </form>
                        
                        <!-- Edit Slider -->
                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editModal<?php echo $row['id']; ?>">
                            Edit
                        </button>
                        
                        <!-- Delete Slider -->
                        <form action="admin_slider.php" method="post" class="d-inline">
                            <input type="hidden" name="slider_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="delete_slider" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this slider?');">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel<?php echo $row['id']; ?>">Edit Slider</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="admin_slider.php" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="slider_id" value="<?php echo $row['id']; ?>">
                                    <div class="form-group">
                                        <label for="title<?php echo $row['id']; ?>">Title:</label>
                                        <input type="text" class="form-control" id="title<?php echo $row['id']; ?>" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description<?php echo $row['id']; ?>">Description:</label>
                                        <textarea class="form-control" id="description<?php echo $row['id']; ?>" name="description" required><?php echo htmlspecialchars($row['description']); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="image_file<?php echo $row['id']; ?>">Change Image File:</label>
                                        <input type="file" class="form-control-file" id="image_file<?php echo $row['id']; ?>" name="image_file">
                                    </div>
                                    <button type="submit" name="update_slider" class="btn btn-primary">Update Slider</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>No sliders found. Add new sliders to manage.</p>
        <?php endif; ?>

        <a href="admin_index.php" class="btn btn-danger mt-3">Back to Dashboard</a>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include 'admin_Footer.php'; ?>
