<?php
include 'conn.php'; // Include your database connection

// Fetch all reviews with associated product details (including image)
$review_sql = "SELECT reviews.id, reviews.reviewer_name, reviews.review_text, product.title AS product_title, product.image AS product_image
               FROM reviews
               JOIN product ON reviews.product_id = product.id"; // Correct table name
$review_result = mysqli_query($conn, $review_sql);

// Check for errors in the query and add error details
if (!$review_result) {
    die('Error fetching reviews: ' . mysqli_error($conn) . ' - SQL: ' . $review_sql);
}

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
        body {
            background: linear-gradient(to right, #4facfe, #00f2fe); /* Light blue gradient */
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            margin-top: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .table-container {
            margin-top: 20px;
            overflow-x: auto;
        }
        table.table {
            width: 100%;
            border-collapse: collapse;
        }
        table.table th, table.table td {
            padding: 12px;
            text-align: left;
        }
        table.table th {
            background-color: #00c6ff;
            color: white;
        }
        table.table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
        .btn-danger {
            background-color: #ff5f6d;
            border-color: #ff5f6d;
        }
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            h1 {
                font-size: 1.5rem;
            }
            table.table th, table.table td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>All Reviews</h1>
        <div class="table-container">
            <?php
            if ($review_result && mysqli_num_rows($review_result) > 0) {
                echo '<table class="table table-striped table-responsive">';
                echo '<thead><tr><th>Product</th><th>Image</th><th>Reviewer Name</th><th>Review</th><th>Actions</th></tr></thead>';
                echo '<tbody>';
                while ($review = mysqli_fetch_assoc($review_result)) {
                    // Assuming image path is stored correctly relative to the project folder
                    $image_path = 'images/' . $review['product_image']; // Adjust 'images/' to the correct folder if needed

                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($review['product_title']) . '</td>';
                    echo '<td><img src="' . htmlspecialchars($image_path) . '" alt="Product Image" class="product-image"></td>'; // Corrected to show the image
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
    </div>
    <script src="path/to/bootstrap.bundle.min.js"></script> <!-- Ensure Bootstrap JS is linked -->
</body>
</html>
