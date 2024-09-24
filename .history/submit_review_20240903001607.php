<?php
// Include your database connection file
include 'conn.php';

// Start the session
session_start();

// Check if the form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input data
    $product_id = intval($_POST['product_id']);
    $reviewer_name = mysqli_real_escape_string($conn, trim($_POST['reviewer_name']));
    $review_text = mysqli_real_escape_string($conn, trim($_POST['review_text']));

    if (empty($reviewer_name) || empty($review_text)) {
        echo "All fields are required!";
        exit;
    }

    // Insert the review into the database
    $sql = "INSERT INTO reviews (product_id, reviewer_name, review_text) VALUES ('$product_id', '$reviewer_name', '$review_text')";
    if (mysqli_query($conn, $sql)) {
        // Redirect back to the product details page
        header("Location: product_details.php?id=$product_id");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request method!";
}
?>
