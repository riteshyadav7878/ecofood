<?php
include 'conn.php'; // Include your database connection file

// Fetch all sliders with active status
$sql = "SELECT * FROM sliders WHERE status = 'active'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sliders Carousel</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .carousel-item img {
            width: 100%;
            height: auto;
        }
        .carousel-caption {
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            padding: 10px;
        }
        .carousel-inner {
            position: relative;
            width: 100%;
            overflow: hidden;
        }
        .carousel-item {
            display: none;
            position: relative;
            width: 100%;
        }
        .carousel-item.active {
            display: block;
        }
        /* Center carousel controls vertically */
        .carousel-control-prev,
        .carousel-control-next {
            width: 5%; /* Adjust width if needed */
            top: 50%;
            transform: translateY(-50%);
        }
    </style>
</head>
<body>
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <ol class="carousel-indicators">
            <?php
            $i = 0;
            while ($row = $result->fetch_assoc()) {
                echo '<li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="' . $i . '"';
                if ($i === 0) echo ' class="active"';
                echo '></li>';
                $i++;
            }
            ?>
        </ol>
        <div class="carousel-inner">
            <?php
            $result->data_seek(0); // Reset pointer to the start of the result set
            $i = 0;
            while ($row = $result->fetch_assoc()) {
                echo '<div class="carousel-item';
                if ($i === 0) echo ' active';
                echo '">';
                echo '<img src="' . htmlspecialchars($row['image_url']) . '" class="d-block w-100" alt="Slider Image">';
                echo '<div class="carousel-caption d-none d-md-block">';
                echo '<h5>' . htmlspecialchars($row['title']) . '</h5>';
                echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                echo '</div></div>';
                $i++;
            }
            ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </a>
    </div>

    <script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Remove jQuery if not needed for Bootstrap 5 -->
    <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
    <script>
        // Initialize carousel manually if needed
        document.addEventListener('DOMContentLoaded', function () {
            var myCarousel = document.querySelector('#carouselExampleIndicators')
            var carousel = new bootstrap.Carousel(myCarousel, {
                interval: 5000 // Adjust the interval for slide transition (5000ms = 5s)
            })
        });
    </script>
</body>
</html>
