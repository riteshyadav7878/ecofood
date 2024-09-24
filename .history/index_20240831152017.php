<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carousel Example</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <?php
            $active = 'active'; // Ensure the first item is active
            while ($slider = $result->fetch_assoc()) {
              $image_url = $slider['image_url'];
              $title = $slider['title'];
              $description = $slider['description'];
              $interval = isset($slider['interval']) ? $slider['interval'] : 5000; // Default interval if not set
            ?>
              <div class="carousel-item <?php echo $active; ?>" data-bs-interval="<?php echo $interval; ?>">
                <img src="<?php echo $image_url; ?>" class="d-block w-100" alt="<?php echo htmlspecialchars($title); ?>">
                <div class="carousel-caption d-none d-md-block">
                  <h5><?php echo htmlspecialchars($title); ?></h5>
                  <p><?php echo htmlspecialchars($description); ?></p>
                </div>
              </div>
            <?php
              $active = ''; // Remove 'active' class from subsequent items
            }
            ?>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap Bundle with Popper (Bootstrap's JavaScript) -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
