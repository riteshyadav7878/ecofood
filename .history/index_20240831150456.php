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
            max-height: 500px; /* Set a max height for images */
            object-fit: cover; /* Ensure the image covers the container without stretching */
            width: 100%; /* Make sure the image fills the width */
        }
    </style>
</head>
<body>
    <section>
        <div class="container mt-4">
            <h1 class="text-center mb-4">Our Sliders</h1>

            <?php if ($result->num_rows > 0): ?>
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $active = 'active';
                    while ($row = $result->fetch_assoc()):
                    ?>
                    <div class="carousel-item <?php echo $active; ?>">
                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" class="d-block w-100" alt="Slider Image">
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p><?php echo htmlspecialchars($row['description']); ?></p>
                        </div>
                    </div>
                    <?php
                    $active = ''; // Reset $active for all subsequent items
                    endwhile;
                    ?>
                </div>
                <!-- Left and right controls/icons -->
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <?php else: ?>
            <p class="text-center">No sliders available at the moment.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Include Bootstrap JS at the end of the body -->
    <script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
