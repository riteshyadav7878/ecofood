<?php
session_start(); // Start the session

// Include database connection
include('conn.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php"); // Redirect to login page if not logged in
    exit();
}

// Fetch all reviews with associated product details (including image)
$review_sql = "SELECT reviews.id, reviews.reviewer_name, reviews.review_text, product.title AS product_title, product.image AS product_image
               FROM reviews
               JOIN product ON reviews.product_id = product.id"; // Correct table name
$review_result = mysqli_query($conn, $review_sql);

// Check for errors in the query
if (!$review_result) {
    die('Error fetching reviews: ' . mysqli_error($conn));
}

// Handle review deletion
if (isset($_GET['delete_id'])) {
    $review_id = intval($_GET['delete_id']);
    $delete_sql = "DELETE FROM reviews WHERE id = $review_id";
    if (mysqli_query($conn, $delete_sql)) {
        echo '<script>alert("Review deleted successfully.");</script>';
        echo '<script>window.location.href="reviews.php";</script>'; // Redirect to see the updated list
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
        /* Custom delete button styling */
        .btn-danger {
            background-color: #e74c3c;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            transition-duration: 0.3s;
            cursor: pointer;
            border-radius: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-danger:hover {
            background-color: #c0392b;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
        }
        .btn-danger:active {
            background-color: #e74c3c;
            box-shadow: none;
            transform: translateY(2px);
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

<?php include 'admin_Navbar.php'; ?>

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
                    $image_path = 'images/' . $review['product_image'];

                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($review['product_title']) . '</td>';
                    echo '<td><img src="' . htmlspecialchars($image_path) . '" alt="Product Image" class="product-image"></td>';
                    echo '<td>' . htmlspecialchars($review['reviewer_name']) . '</td>';
                    echo '<td>' . htmlspecialchars($review['review_text']) . '</td>';
                    echo '<td><a href="reviews.php?delete_id=' . $review['id'] . '" class="btn btn-danger btn-sm" onclick="return confirmDelete();">Delete</a></td>';
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

    <?php include 'admin_Footer.php'; ?>
    <script src="path/to/bootstrap.bundle.min.js"></script> <!-- Ensure Bootstrap JS is linked -->
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this review?");
        }
    </script>
</body>
</html>
