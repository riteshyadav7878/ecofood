<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php"); // Redirect to login page
    exit();
}

// Include other necessary files
include 'conn.php';

?>
<header>

<!--    Navbar -->
 


<div class="section dark-background">
<div class="container">
<div class="header-2">
<div class="header-left">
<p>
<i class="fa fa-map-marker"></i>256 Address Name, New York city
<span>|</span>
<i class="fa fa-clock-o"></i>07:30 Am - 11:00 Pm</p>
</div>
<div class="header-right">
<div class="header-login">
<a href="login.php">
<i class="fa fa-user"></i>Log in</a>
<span>/</span>
<a href="register.php">Register</a>
 
</div>
<span class="divider">|</span>
<div class="header-search">
<button class="fa fa-search"></button>
<div class="search-box">
<input type="text" placeholder="Search..." />
</div>
</div>
</div>
</div>
</div>
</div>

</header>
<?php include 'admin_Navbar.php'; ?>

 <h1>Welcome a admin site pages</h1>

<?php include 'admin_Footer.php'; ?>