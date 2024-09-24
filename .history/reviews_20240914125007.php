<?php
include 'conn.php'; // Include your database connection

// Fetch all products for review submission
$product_sql = "SELECT * FROM products"; // Ensure this table exists
$product_result = mysqli_query($conn, $product_sql);

// Check for errors in the query
if (!$product_result) {
    die('Error fetching products: ' . mysqli_error($conn));
}

// Fetch all reviews with associated product details
$review_sql = "SELECT reviews.id, reviews.reviewer_name, reviews.review_text, products.title AS product_title
               FROM reviews
               JOIN products ON reviews.product_id = products.id"; // Ensure this table exists
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
        header('Location: reviews.php'); // Redirect to the same page to see updated list
        exit();
    } else {
        echo 'Error deleting review: ' . mysqli_error($conn);
    }
}
?>
