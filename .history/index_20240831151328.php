<?php
session_start();
include 'conn.php'; // Include your database connection file

// Fetch all active sliders
$sql = "SELECT * FROM sliders WHERE status = 'active'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sliders Showcase</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Light background color */
        }
        .carousel-item img {
            max-height: 500px; /* Set a maximum height for carousel images */
            object-fit: cover; /* Ensures the image covers the container */
        }
        .carousel-caption {
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background for captions */
            padding: 10px;
        }
    </style>
</head>
<body>

    <div class="container mt-4">
        <h1 class="text-center mb-4">Our Sliders</h1>
        
        <?php if ($result->num_rows > 0): ?>
        <div id="sliderCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?php
                $active = 'active';
                while ($row = $result->fetch_assoc()):
                ?>
                <div class="carousel-item <?php echo $active; ?>">
                    <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Slider Image" class="d-block w-100">
                    <div class="carousel-caption d-none d-md-block">
                        <h5><?php echo htmlspecialchars($row['title']); ?></h5>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                    </div>
                </div>
                <?php
                $active = ''; // Only the first item should have the 'active' class
                endwhile;
                ?>
            </div>
            <a class="carousel-control-prev" href="#sliderCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#sliderCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <?php else: ?>
        <p class="text-center">No sliders available at the moment.</p>
        <?php endif; ?>

    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include 'footer.php'; ?>
