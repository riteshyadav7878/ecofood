<?php
// Database connection
require 'conn.php';

// Fetch reviews from the database
$sql = "SELECT * FROM reviews";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Submitted Reviews</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product ID</th>
                    <th>Reviewer Name</th>
                    <th>Review Text</th>
                    <!-- Remove this column if 'created_at' doesn't exist -->
                    <!-- <th>Created At</th> -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['product_id']; ?></td>
                            <td><?php echo $row['reviewer_name']; ?></td>
                            <td><?php echo $row['review_text']; ?></td>
                            <!-- Remove this line if 'created_at' doesn't exist -->
                            <!-- <td><?php echo $row['created_at']; ?></td> -->
                            <td>
                                <a href="delete_review.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No reviews found.</td> <!-- Update colspan if you removed a column -->
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
