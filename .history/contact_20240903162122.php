<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h2>Contact Us</h2>
    <p>We're happy to answer your questions or hear your feedback. Please fill out the form below:</p>

    <!-- Contact Form -->
    <form action="contact.php" method="post">
        <div class="form-group">
            <label for="name">Your Name *</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Your Email *</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="message">Your Message *</label>
            <textarea name="msg" id="message" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <?php
    // Include database connection file
    include 'conn.php';

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data and sanitize input
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $message = mysqli_real_escape_string($conn, $_POST['msg']);

        // Insert form data into the database
        $sql = "INSERT INTO contact_submissions (name, email, message) VALUES ('$name', '$email', '$message')";

        if (mysqli_query($conn, $sql)) {
            echo "<div class='alert alert-success'>Thank you for contacting us. We will get back to you soon.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</div>";
        }

        // Close the database connection
        mysqli_close($conn);
    }
    ?>
</div>

<!-- Include Bootstrap JS and dependencies -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
