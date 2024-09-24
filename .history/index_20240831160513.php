<?php
include 'conn.php'; // Include your database connection file

// Fetch all sliders
$sql = "SELECT * FROM sliders WHERE status = 'active'"; // Only fetch active sliders
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Carousel</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <style>
        .carousel-item img {
            width: 100%;
            height: auto;
            display: inline;
        }
        .carousel-caption {
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            padding: 10px;
        }
        body {
            background-color: #f4f6f9; /* Light background */
        }
        .carousel-control-prev, .carousel-control-next {
            width: 5%; /* Adjust width for better fit */
        }
    </style>
</head>
<body>
<?php if ($result->num_rows > 0): ?>
<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-indicators">
        <!-- Indicators here -->
        <div class="carousel-indicators">
                <?php
                $i = 0;
                // Generate carousel indicators
                while ($row = $result->fetch_assoc()) {
                    echo '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="' . $i . '"';
                    if ($i === 0) echo ' class="active" aria-current="true"';
                    echo ' aria-label="Slide ' . ($i + 1) . '"></button>';
                    $i++;
                }
                ?>
            </div>

    </div>
    <div class="carousel-inner">
        <!-- Carousel items here -->
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
