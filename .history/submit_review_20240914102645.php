<?php
session_name("user_session");
// Include your database connection file
include 'conn.php';

// Start the session
session_start();

// Check if review data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get review data
    $product_id = intval($_POST['product_id']);
    $reviewer_name = mysqli_real_escape_string($conn, $_POST['reviewer_name']);
    $review_text = mysqli_real_escape_string($conn, $_POST['review_text']);

    // Insert review into the database
    $sql = "INSERT INTO reviews (product_id, reviewer_name, review_text) VALUES ('$product_id', '$reviewer_name', '$review_text')";
    if (mysqli_query($conn, $sql)) {
        // Redirect to the product details page
        header("Location: product_details.php?id=$product_id");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
mysqli_close($conn);
?>
