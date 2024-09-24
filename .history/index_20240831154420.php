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
        .carousel-control-prev,
        .carousel-control-next {
            width: 5%;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
        }
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.5); /* Background color for the icons */
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?php
            $i = 0;
            while ($row = $result->fetch_assoc()) {
                echo '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="' . $i . '"';
                if ($i === 0) echo ' class="active" aria-current="true"';
                echo ' aria-label="Slide ' . ($i + 1) . '"></button>';
                $i++;
            }
            ?>
        </div>
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
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
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
        .carousel-control-prev,
        .carousel-control-next {
            width: 5%;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
        }
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.5); /* Background color for the icons */
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?php
            $i = 0;
            while ($row = $result->fetch_assoc()) {
                echo '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="' . $i . '"';
                if ($i === 0) echo ' class="active" aria-current="true"';
                echo ' aria-label="Slide ' . ($i + 1) . '"></button>';
                $i++;
            }
            ?>
        </div>
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
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <script src="vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
