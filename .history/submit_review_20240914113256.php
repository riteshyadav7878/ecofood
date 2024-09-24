<?php
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
        // Refresh the same page to avoid form resubmission
        header("Location: " . $_SERVER['PHP_SELF'] . "?id=$product_id&review_success=1");
        exit(); // Ensure script ends after the redirect
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
mysqli_close($conn);
?>
