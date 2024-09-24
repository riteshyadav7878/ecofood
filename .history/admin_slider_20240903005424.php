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
                    $error = error_get_last();
                    echo "<div class='alert alert-danger'>Sorry, there was an error uploading your file. " . htmlspecialchars($error['message']) . "</div>";
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
                    $error = error_get_last();
                    echo "<div class='alert alert-danger'>Sorry, there was an error uploading your file. " . htmlspecialchars($error['message']) . "</div>";
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
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
        .alert {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Slider Management</h2>
        <!-- Add Slider Form -->
        <div class="card">
            <div class="card-header">Add New Slider</div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image_file">Upload Image:</label>
                        <input type="file" class="form-control-file" id="image_file" name="image_file" required>
                    </div>
                    <button type="submit" name="add_slider" class="btn btn-primary">Add Slider</button>
                </form>
            </div>
        </div>

        <!-- Existing Sliders -->
        <h3>Existing Sliders</h3>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                </div>
                <div class="card-body">
                    <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['title']) ?>" class="img-fluid">
                    <p class="card-text"><?= htmlspecialchars($row['description']) ?></p>
                    <form action="" method="post" style="display:inline-block;">
                        <input type="hidden" name="slider_id" value="<?= htmlspecialchars($row['id']) ?>">
                        <input type="hidden" name="current_status" value="<?= htmlspecialchars($row['status']) ?>">
                        <button type="submit" name="toggle_status" class="btn btn-warning"><?= htmlspecialchars($row['status']) == 'active' ? 'Deactivate' : 'Activate' ?></button>
                    </form>
                    <form action="" method="post" style="display:inline-block;">
                        <input type="hidden" name="slider_id" value="<?= htmlspecialchars($row['id']) ?>">
                        <button type="submit" name="delete_slider" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>
