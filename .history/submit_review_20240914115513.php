<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Review</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<!-- Success/Failure message -->
<p id="message" style="display: none;"></p>

<!-- Review Form -->
<form id="reviewForm">
    <input type="hidden" name="product_id" value="<?php echo $_GET['id']; ?>" />

    <label for="reviewer_name">Your Name:</label>
    <input type="text" name="reviewer_name" id="reviewer_name" required><br><br>

    <label for="review_text">Your Review:</label>
    <textarea name="review_text" id="review_text" required></textarea><br><br>

    <button type="submit">Submit Review</button>
</form>

<script>
$(document).ready(function() {
    $('#reviewForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        $.ajax({
            type: 'POST',
            url: '', // Submit to the same PHP page
            data: $(this).serialize(), // Serialize form data
            dataType: 'json', // Expect JSON response from PHP
            success: function(response) {
                // Show success or error message
                if (response.success) {
                    $('#message').text(response.message).css('color', 'green').show();
                    $('#reviewForm')[0].reset(); // Clear form fields after successful submission
                } else {
                    $('#message').text(response.message).css('color', 'red').show();
                }
            },
            error: function() {
                // Show an error message if the request fails
                $('#message').text('An unexpected error occurred.').css('color', 'red').show();
            }
        });
    });
});
</script>

</body>
</html>
