<?php
session_start();
include 'conn.php';

// Check if the user is logged in; if so, redirect to a different page
if (isset($_SESSION['username'])) {
    header("Location: shop-list-without-sidebar.php");
    exit();
}

// Fetch blog posts from the database
$query = "SELECT * FROM blog_posts"; // Ensure this matches the actual table name
$result = mysqli_query($conn, $query);

// Check for query errors
if (!$result) {
    die('Error: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blog List with Sidebar</title>
    <!-- Add your CSS and other head elements here -->
</head>
<body>

<!-- Page Loader and Header here -->

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
                    <li><a href="index.php">Home</a></li>
                    <li><a href="blog-list-with-sidebar-1.php">Our Blog</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<div class="page-content blog-list-page-1 p-t-40 p-b-100">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-push-8">
                <!-- Sidebar content here -->
            </div>
            <div class="col-md-8 col-md-pull-4">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="blog-item-1">
                        <div class="blog-item-image">
                            <a href="#">
                                <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" />
                            </a>
                        </div>
                        <div class="blog-item-title">
                            <h3 class="title">
                                <a href="#"><?php echo htmlspecialchars($row['title']); ?></a>
                            </h3>
                        </div>
                        <p class="blog-item-date">
                            <i class="fa fa-clock-o"></i>
                            <span>on <?php echo htmlspecialchars($row['publish_date']); ?></span>
                        </p>
                        <p class="blog-item-content"><?php echo htmlspecialchars($row['content']); ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<!-- Popup HTML -->

<?php include 'Footer.php'; ?>

<script>
    // JavaScript code for popup functionality
</script>
</body>
</html>
