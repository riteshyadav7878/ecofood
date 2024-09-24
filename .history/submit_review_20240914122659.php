<?php
// Include your database connection file


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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Review</title>
    <style>
        /* Fullscreen success message overlay */
        #success-overlay {
            display: none; /* Hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 128, 0, 0.8); /* Green background with opacity */
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 2rem;
            z-index: 9999; /* On top of everything */
        }

        /* Message styling */
        #success-message {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            color: green;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            position: relative;
        }

        /* Back button styling */
        #back-button {
            display: block;
            margin: 20px auto 0;
            padding: 10px 20px;
            font-size: 1rem;
            color: white;
            background-color: green;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #back-button:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>

<!-- Fullscreen success message -->
<div id="success-overlay">
    <div id="success-message">
        Your review was submitted successfully!
        <button id="back-button" onclick="window.history.back()">Back</button>
    </div>
</div>

<script>
    // Function to show the success message overlay
    function showSuccessMessage() {
        document.getElementById('success-overlay').style.display = 'flex';
    }

    // Example usage: Show the success message when the page loads
    window.onload = function() {
        showSuccessMessage(); // Call this function based on your condition
    };
</script>

</body>
</html>
