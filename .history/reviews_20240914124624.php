<?php
include 'conn.php'; // Include your database connection

// Fetch all products for review submission
$product_sql = "SELECT * FROM products";
$product_result = mysqli_query($conn, $product_sql);

// Fetch all reviews with associated product details
$review_sql = "SELECT reviews.id, reviews.reviewer_name, reviews.review_text, products.title AS product_title
               FROM reviews
               JOIN products ON reviews.product_id = products.id";
$review_result = mysqli_query($conn, $review_sql);

// Handle review deletion
if (isset($_GET['delete_id'])) {
    $review_id = intval($_GET['delete_id']);
    $delete_sql = "DELETE FROM reviews WHERE id = $review_id";
    if (mysqli_query($conn, $delete_sql)) {
        header('Location: reviews.php'); // Redirect to the same page to see updated list
        exit();
    } else {
        echo 'Error deleting review: ' . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews Management</title>
    <link rel="stylesheet" href="path/to/bootstrap.min.css"> <!-- Ensure Bootstrap CSS is linked -->
    <style>
        .table-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>All Reviews</h1>
        <div class="table-container">
            <?php
            if (mysqli_num_rows($review_result) > 0) {
                echo '<table class="table table-striped">';
                echo '<thead><tr><th>Product</th><th>Reviewer Name</th><th>Review</th><th>Actions</th></tr></thead>';
                echo '<tbody>';
                while ($review = mysqli_fetch_assoc($review_result)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($review['product_title']) . '</td>';
                    echo '<td>' . htmlspecialchars($review['reviewer_name']) . '</td>';
                    echo '<td>' . htmlspecialchars($review['review_text']) . '</td>';
                    echo '<td><a href="reviews.php?delete_id=' . $review['id'] . '" class="btn btn-danger btn-sm">Delete</a></td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p>No reviews available.</p>';
            }
            ?>
        </div>

        <h2>Submit a Review</h2>
        <form action="submit_review.php" method="post">
            <div class="mb-3">
                <label for="product" class="form-label">Select Product</label>
                <select class="form-select" id="product" name="product_id" required>
                    <?php
                    while ($product = mysqli_fetch_assoc($product_result)) {
                        echo '<option value="' . $product['id'] . '">' . htmlspecialchars($product['title']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="reviewer-name" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="reviewer-name" name="reviewer_name" required>
            </div>
            <div class="mb-3">
                <label for="review-text" class="form-label">Your Review</label>
                <textarea class="form-control" id="review-text" name="review_text" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
    </div>
    <script src="path/to/bootstrap.bundle.min.js"></script> <!-- Ensure Bootstrap JS is linked -->
</body>
</html>
