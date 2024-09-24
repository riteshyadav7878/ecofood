<?php
include 'conn.php'; // Include your database connection file

// Fetch all sliders
$sql = "SELECT * FROM sliders WHERE status='active'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sliders</title>
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9; /* Light background */
        }
        .carousel-item img {
            max-height: 500px;
            object-fit: cover;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Our Sliders</h1>

        <?php if ($result->num_rows > 0): ?>
        <div id="sliderCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                $active = 'active';
                while ($row = $result->fetch_assoc()):
                ?>
                <div class="carousel-item <?php echo $active; ?>">
                    <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Slider Image">
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
            <!-- Left and right controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#sliderCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#sliderCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <?php else: ?>
        <p class="text-center">No sliders available at the moment.</p>
        <?php endif; ?>
    </div>

    <!-- Include jQuery and Bootstrap JS at the end of the body -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
