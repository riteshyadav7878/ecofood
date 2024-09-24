<?php
include 'conn.php'; // Include your database connection file

// Fetch all active sliders
$sql = "SELECT * FROM slider WHERE status='active'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Image Carousel</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .carousel-item img {
            width: 100%;
            height: auto; /* Ensure image maintains aspect ratio */
        }
    </style>
</head>
<body>
    <div class="container_ mt-4">
        <h1 class="text-center mb-4">Image Carousel</h1>

        <!-- Bootstrap Carousel -->
        <div id="carouselExampleIndicators" class="carousel slide">
            <ol class="carousel-indicators">
                <?php $i = 0; while($row = $result->fetch_assoc()): ?>
                    <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i; ?>" class="<?php echo $i == 0 ? 'active' : ''; ?>"></li>
                <?php $i++; endwhile; ?>
            </ol>
            <div class="carousel-inner">
                <?php
                $result->data_seek(0); // Reset result pointer to the start
                $i = 0;
                while($row = $result->fetch_assoc()):
                ?>
                    <div class="carousel-item <?php echo $i == 0 ? 'active' : ''; ?>">
                        <img src="<?php echo $row['image_url']; ?>" class="d-block w-100" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p><?php echo htmlspecialchars($row['description']); ?></p>
                        </div>
                    </div>
                <?php $i++; endwhile; ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <!-- Include jQuery, Popper.js, and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
