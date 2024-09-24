<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Review</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<!-- Review Form -->
<form id="reviewForm">
    <input type="hidden" name="product_id" value="<?php echo $_GET['id']; ?>" />

    <label for="reviewer_name">Your Name:</label>
    <input type="text" name="reviewer_name" id="reviewer_name" required><br><br>

    <label for="review_text">Your Review:</label>
    <textarea name="review_text" id="review_text" required></textarea><br><br>

    <button type="submit">Submit Review</button>
</form>

<p id="message" style="display:none; color: green;"></p>

<script>
$(document).ready(function() {
    $('#reviewForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        $.ajax({
            type: 'POST',
            url: '', // Submitting to the same PHP file
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#message').text('Thank you! Your review has been submitted successfully.').show();
                    $('#reviewForm')[0].reset(); // Reset form after submission
                } else {
                    $('#message').text('Error: ' + response.message).css('color', 'red').show();
                }
            },
            error: function() {
                $('#message').text('An unexpected error occurred.').css('color', 'red').show();
            }
        });
    });
});
</script>

</body>
</html>
