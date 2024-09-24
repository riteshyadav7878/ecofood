<?php
// Include your database connection file
include 'conn.php';

// Start the session
session_start();

// Initialize a variable to store the success message
$success_message = "";

// Check if review data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get review data
    $product_id = intval($_POST['product_id']);
    $reviewer_name = mysqli_real_escape_string($conn, $_POST['reviewer_name']);
    $review_text = mysqli_real_escape_string($conn, $_POST['review_text']);

    // Insert review into the database
    $sql = "INSERT INTO reviews (product_id, reviewer_name, review_text) VALUES ('$product_id', '$reviewer_name', '$review_text')";
    if (mysqli_query($conn, $sql)) {
        // Set the success message
        $success_message = "Your review was submitted successfully.";
    } else {
        $success_message = "Error: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>