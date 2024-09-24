 <?php
    session_name("user_session");
    session_start();
    include 'conn.php';

    // If the user is already logged in, redirect them to the protected page
    if (isset($_SESSION['username'])) {
        header("Location: shop-list-without-sidebar.php");
        exit();
    }

    // Get the blog ID from the query parameter
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Fetch the selected blog post from the database
    $sql = "SELECT * FROM blogs WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $blog = mysqli_fetch_assoc($result);

    // Fetch other blog posts from the database
    $sql_other = "SELECT * FROM blogs WHERE id != ? ORDER BY created_at DESC";
    $stmt_other = mysqli_prepare($conn, $sql_other);
    mysqli_stmt_bind_param($stmt_other, 'i', $id);
    mysqli_stmt_execute($stmt_other);
    $result_other = mysqli_stmt_get_result($stmt_other);
    ?>

 <!DOCTYPE html>
 <html class="no-js" lang="en">

 <head>
     <meta charset="UTF-8">
     <title><?php echo htmlspecialchars($blog['title']); ?></title>
     <meta name="description" content="Blog post page">
     <meta name="author" content="Your Name">
     <meta name="keywords" content="blog, post">
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
     <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.png">
     <style>
         .blog-content img {
             width: 100%;
             height: auto;
             max-height: 500px;
             /* Ensure image height does not exceed this value */
             object-fit: cover;
             margin-bottom: 20px;
         }

         .blog-description {
             font-size: 20px;
             /* Set font size */
             margin-top: 20px;
             /* Space above description */
             line-height: 1;
             /* Adjust line height for spacing between lines */
             word-wrap: break-word;
             /* Ensure long words break and wrap */
         }

         .blog-title {
             font-size: 30px;
             /* Set font size */
             font-weight: bold;
             /* Make font bold */
             margin-bottom: 20px;
             /* Add spacing below title */
         }

         .sidebar img {
             width: 100%;
             height: auto;
             max-height: 200px;
             /* Adjust max height for sidebar images */
             object-fit: cover;
             margin-bottom: 10px;
         }

         .row {
             margin-left: -15px;
             margin-right: -15px;
         }

         .col-md-4,
         .col-md-8 {
             padding-left: 15px;
             padding-right: 15px;
         }

         .blog-item {
             margin-bottom: 30px;
         }

         .sidebar {
             border: 1px solid #ddd;
             padding: 15px;
             margin-top: 20px;
         }

         /* Date Icon */
         .date-icon {
             font-size: 30px;
             /* Adjust icon size */
             color: green;
             /* Icon color */
             margin-right: 10px;
             /* Space between icon and date text */
         }

         .date-container {
             font-size: 20px;
             /* Font size for date text */
             color: #333;
             /* Date text color */
             margin-top: 10px;
             /* Space above the date */
         }

         /* Ensures responsiveness */
         @media (max-width: 768px) {

             .col-md-8,
             .col-md-4 {
                 width: 100%;
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
                         <h3 class="blog-title"><?php echo htmlspecialchars($blog['title']); ?></h3>
                     </div>
                 </div>
             </div>
         </div>
     </section>

     <div class="page-content blog-post-page p-t-40 p-b-100">
         <div class="container">
             <div class="row">
                 <div class="col-md-8">
                     <div class="blog-content">
                         <img src="images/<?php echo htmlspecialchars($blog['image']); ?>"
                             alt="<?php echo htmlspecialchars($blog['title']); ?>">
                         <h3 class="blog-title"><?php echo htmlspecialchars($blog['title']); ?></h3>
                         <div class="blog-description">
                             <p><?php echo htmlspecialchars($blog['description']); ?></p>
                         </div>
                         <div class="date-container">
                             <i class="fa fa-clock-o"></i>
                             <span><?php echo date('F j, Y', strtotime($blog['created_at'])); ?></span>
                         </div>
                     </div>
                 </div>
                 <div class="col-md-4">
                     <div class="sidebar">
                         <h4>Other Blog Posts</h4>
                         <div class="row">
                             <?php while ($row_other = mysqli_fetch_assoc($result_other)): ?>
                                 <div class="col-md-12">
                                     <a href="blog.php?id=<?php echo urlencode($row_other['id']); ?>">
                                         <img src="images/<?php echo htmlspecialchars($row_other['image']); ?>"
                                             alt="<?php echo htmlspecialchars($row_other['title']); ?>">
                                         <h5><?php echo htmlspecialchars($row_other['title']); ?></h5>
                                     </a>
                                 </div>
                             <?php endwhile; ?>
                         </div>
                     </div>
                 </div>
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
 </body>

 </html>