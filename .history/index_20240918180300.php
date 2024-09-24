<?php
// Include database connection file
include 'conn.php';

// Fetch carousel items from the database
$query = "SELECT image_url, title, description FROM carousel_items";
$result = $conn->query($query);

// Check if the query was successful
if (!$result) {
    die("Database query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carousel Example</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .carousel-item img {
            width: 100%;
            height: 500px;
            /* Fixed height for images */
            object-fit: cover;
            /* Ensure images cover the area without distortion */
            border: 5px solid #fff;
            /* White border around images */
            border-radius: 10px;
            /* Optional: rounded corners for the border */
        }

        .carousel-caption {
            text-align: center;
            /* Center align text */
            background-color: rgba(0, 0, 0, 0.5);
            /* Semi-transparent background for readability */
            padding: 15px;
            /* Add padding */
            border-radius: 5px;
            /* Rounded corners for caption box */
        }

        .carousel-caption h5 {
            font-weight: bold;
            /* Make title bold */
            font-size: 3rem;
            /* Increase font size of title */
        }

        .carousel-caption p {
            font-size: 2rem;
            /* Increase font size of description */
        }

        .carousel-control-prev,
        .carousel-control-next {
            color: #6c757d;
            /* Secondary color for the controls (gray) */
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: #6c757d;
            /* Secondary color for the control icons background */
        }
    </style>
</head>
<body>
    <section>
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                <?php $i = 0; while ($row = $result->fetch_assoc()): ?>
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $i; ?>" class="<?php echo $i == 0 ? 'active' : ''; ?>"></li>
                <?php $i++; endwhile; ?>
            </ol>
            <div class="carousel-inner">
                <?php
                $result->data_seek(0); // Reset result pointer to the start
                $i = 0;
                while ($row = $result->fetch_assoc()): ?>
                    <div class="carousel-item <?php echo $i == 0 ? 'active' : ''; ?>">
                        <img src="<?php echo $row['image_url']; ?>" class="d-block w-100" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p><?php echo htmlspecialchars($row['description']); ?></p>
                        </div>
                    </div>
                <?php $i++; endwhile; ?>
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
    </section>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        // Optional: Configure the carousel to slide automatically
        var carousel = document.querySelector('#carouselExampleIndicators');
        var carouselInstance = new bootstrap.Carousel(carousel, {
            interval: 5000 // Interval in milliseconds (5 seconds)
        });
    </script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
