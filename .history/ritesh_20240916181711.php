<?php
session_name("user_session");
session_start();
include 'conn.php';

// If the user is already logged in, redirect them to the protected page
 
// Fetch blog posts from the database
$sql = "SELECT * FROM blogs ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="UTF-8">
    <title>Blog</title>
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
            background: #000;
            color: #fff;
            padding: 20px;
            border-radius: 5px;
            position: relative;
            max-width: 90%;
            max-height: 90%;
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow: hidden;
        }

        .popup img {
            width: 100%;
            max-width: 600px;
            height: auto;
            max-height: 400px;
            object-fit: cover;
        }

        .popup-close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
            color: #fff;
        }

        .popup-header {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .popup-description {
            font-size: 16px;
            margin-top: 10px;
        }

        .blog-item-1 {
            margin-bottom: 30px;
        }

        .blog-item-image img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            display: block;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .col-md-6 {
                width: 100%;
                margin-bottom: 20px;
            }

            .blog-item-image img {
                height: 200px;
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

        <div class="section dark-background">
            <div class="container">
                <div class="header-2">
                    <div class="header-left">
                        <p>
                            <i class="fa fa-map-marker"></i>256 Address Name, New York city
                            <span>|</span>
                            <i class="fa fa-clock-o"></i>07:30 Am - 11:00 Pm
                        </p>
                    </div>
                    <div class="header-right">
                        <div class="header-login">
                            <a href="login.php">
                                <i class="fa fa-user"></i>Log in</a>
                            <span>/</span>
                            <a href="register.php">Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-6">
                        <div class="blog-item-1">
                            <div class="blog-item-image">
                                <a href="blog.php?id=<?php echo urlencode($row['id']); ?>" class="popup-link">
                                    <img src="images/<?php echo htmlspecialchars($row['image']); ?>"
                                        alt="<?php echo htmlspecialchars($row['title']); ?>" />
                                </a>
                            </div>
                            <div class="blog-item-title">
                                <h3 class="title">
                                    <a href="blog.php?id=<?php echo urlencode($row['id']); ?>"><?php echo htmlspecialchars($row['title']); ?></a>
                                </h3>
                            </div>
                            <p class="blog-item-content"><?php echo htmlspecialchars($row['description']); ?></p>
                            <p class="blog-item-date">
                                <i class="fa fa-clock-o"></i>
                                <span><?php echo date('F j, Y', strtotime($row['created_at'])); ?></span>
                            </p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
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
        function openPopup(src, title, description) {
            var popup = document.getElementById('popup');
            var popupImg = document.getElementById('popup-img');
            var popupTitle = document.getElementById('popup-title');
            var popupDescription = document.getElementById('popup-description');
            popup.style.display = 'flex';
            popupImg.src = src;
            popupTitle.textContent = title;
            popupDescription.textContent = description;
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
        document.querySelectorAll('.popup-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent the default link behavior
                var href = this.getAttribute('href');
                window.location.href = href; // Navigate to blog.php with ID
            });
        });
    </script>
</body>

</html>
