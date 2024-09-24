<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Slider Management</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e9ecef; /* Light gray background */
        }
        .container {
            margin-top: 20px;
        }
        h1 {
            color: #007bff; /* Bootstrap primary color */
        }
        .card-header {
            background-color: #28a745; /* Green background */
            color: #fff;
        }
        .card-body {
            background-color: #f8f9fa; /* Light background for content */
        }
        .table {
            background-color: #ffffff; /* White background for the table */
        }
        .table thead {
            background-color: #007bff; /* Bootstrap primary color for table headers */
            color: #fff;
        }
        .btn-primary, .btn-success, .btn-warning, .btn-danger, .btn-secondary {
            border-radius: 50px; /* Rounded buttons */
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
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
            font-weight: bold;
        }
        .form-control {
            border-radius: 5px;
        }
        .alert {
            margin-top: 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        .modal-header {
            background-color: #007bff;
            color: #fff;
        }
        .modal-footer .btn {
            border-radius: 50px;
        }
    </style>
</head>
<body>
    <div class="container mb-5">
        <h1 class="mb-4 text-center">Manage Sliders</h1>
        
        <!-- Add Slider Form -->
        <div class="card mb-4">
            <div class="card-header">
                Add New Slider
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image_file">Upload Image</label>
                        <input type="file" class="form-control-file" name="image_file" id="image_file" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="add_slider">Add Slider</button>
                </form>
            </div>
        </div>

        <!-- Sliders Table -->
        <div class="card">
            <div class="card-header">
                Existing Sliders
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><img src="<?php echo $row['image_url']; ?>" alt="Slider Image" width="100"></td>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td>
                                <form action="" method="post" style="display:inline;">
                                    <input type="hidden" name="slider_id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="current_status" value="<?php echo $row['status']; ?>">
                                    <button type="submit" class="btn btn-<?php echo ($row['status'] == 'active') ? 'warning' : 'success'; ?>" name="toggle_status">
                                        <?php echo ($row['status'] == 'active') ? 'Deactivate' : 'Activate'; ?>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form action="" method="post" style="display:inline;">
                                    <input type="hidden" name="slider_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-danger" name="delete_slider">Delete</button>
                                </form>
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editModal<?php echo $row['id']; ?>">Edit</button>
                                
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
                                                <form action="" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" name="slider_id" value="<?php echo $row['id']; ?>">
                                                    <div class="form-group">
                                                        <label for="title">Title</label>
                                                        <input type="text" class="form-control" name="title" id="title" value="<?php echo $row['title']; ?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="description">Description</label>
                                                        <textarea class="form-control" name="description" id="description" rows="3" required><?php echo $row['description']; ?></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="image_file">Upload New Image (Optional)</label>
                                                        <input type="file" class="form-control-file" name="image_file" id="image_file">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary" name="update_slider">Update Slider</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include 'admin_Footer.php'; // Include the admin footer ?>
    <script src="vendor/jquery/dist/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
