<?php
session_start();
include 'conn.php';

// If the user is already logged in, redirect them to the protected page
if (isset($_SESSION['username'])) {
    header("Location: shop-list-without-sidebar.php");
    exit();
}

// Fetch blog posts from the database
$sql = "SELECT * FROM blogs ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blog List</title>
    <meta name="description" content="Blog list page">
    <meta name="author" content="Your Name">
    <meta name="keywords" content="blog, list">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="fonts/fonts.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/css-hamburgers/dist/hamburgers.min.css" rel="stylesheet">
    <link href="vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css" rel="stylesheet">
    <link href="vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/switcher.css" rel="stylesheet">
    <link href="css/colors/green.css" rel="stylesheet" id="colors">
    <link href="css/retina.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.png">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.html">
    <style>
        /* Style for the popup */
        .popup {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .popup-content {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            position: relative;
        }
        .popup img {
            max-width: 100%;
            height: auto;
        }
        .popup-close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
        }

        .blog-item-1 {
            margin-bottom: 30px;
        }

        .blog-item-image img {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 5px;
        }

        .blog-item-title {
            margin-top: 15px;
        }

        .blog-item-date {
            margin: 10px 0;
            font-size: 14px;
        }

        .blog-item-content {
            font-size: 16px;
            line-height: 1.5;
        }

        @media (max-width: 767px) {
            .blog-item-1 {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>

<div class="page-loader">
    <div class="loader"></div>
</div>
<div id="switcher">
    <!-- Switcher content here -->
</div>
<header>
    <!-- Header content here -->
</header>
<?php include 'Navbar.php'; ?>

<section>
    <div class="section primary-color-background">
        <div class="container">
            <div class="p-t-70 p-b-85">
                <div class="heading-page-1">
                    <h3>Our Blog</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="section border-bottom-grey">
        <div class="container">
            <div class="breadcrumb-1">
                <ul>
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="blog-list-with-sidebar-1.php">Our Blog</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<div class="page-content blog-list-page-1 p-t-40 p-b-100">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-push-8">
                <div class="p-l-15 page-sidebar">
                    <!-- Sidebar content here -->
                </div>
            </div>
            <div class="col-md-8 col-md-pull-4">
                <div class="row">
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <div class="col-md-4">
                            <div class="blog-item-1">
                                <div class="blog-item-image">
                                    <a href="#">
                                        <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" />
                                    </a>
                                </div>
                                <div class="blog-item-title">
                                    <h3 class="title">
                                        <a href="#"><?php echo htmlspecialchars($row['title']); ?></a>
                                    </h3>
                                </div>
                                <p class="blog-item-date">
                                    <i class="fa fa-clock-o"></i>
                                    <span><?php echo date('F j, Y', strtotime($row['created_at'])); ?></span>
                                </p>
                                <p class="blog-item-content"><?php echo htmlspecialchars($row['description']); ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Popup HTML -->
<div id="popup" class="popup">
    <div class="popup-content">
        <span class="popup-close">&times;</span>
        <img id="popup-img" src="" alt="Popup Image">
        <p id="popup-caption"></p>
    </div>
</div>

<?php include 'Footer.php'; ?>

<div id="up-to-top">
    <i class="fa fa-angle-up"></i>
</div>

<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vendor/retinajs/dist/retina.min.js"></script>
<script src="vendor/SmoothScroll/SmoothScroll.js"></script>
<script src="js/switcher-custom.js"></script>
<script src="js/main.js"></script>
<script>
    // Function to open the popup
    function openPopup(src, caption) {
        var popup = document.getElementById('popup');
        var popupImg = document.getElementById('popup-img');
        var popupCaption = document.getElementById('popup-caption');
        popup.style.display = 'flex';
        popupImg.src = src;
        popupCaption.textContent = caption;
    }

    // Function to close the popup
    function closePopup() {
        var popup = document.getElementById('popup');
        popup.style.display = 'none';
    }

    // Add event listener to close the popup when clicking the close button
    document.querySelector('.popup-close').addEventListener('click', closePopup);

    // Add event listener to close the popup when clicking outside the popup content
    document.getElementById('popup').addEventListener('click', function(e) {
        if (e.target === this) {
            closePopup();
        }
    });

    // Add event listeners to blog item images
    document.querySelectorAll('.blog-item-image a').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent the default link behavior
            var img = this.querySelector('img');
            openPopup(img.src, img.alt);
        });
    });
</script>
</body>
</html>
