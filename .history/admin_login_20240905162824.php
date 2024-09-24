<?php
// Include database connection
include('conn.php');
session_start(); // Start session

// Redirect to welcome page if user is already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin_index.php"); // Redirect to a logged-in area
    exit();
}
 
 include 'admin_Navbar.php';
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login_admin'])) {
        $username = $conn->real_escape_string(trim($_POST['username']));
        $password = $conn->real_escape_string(trim($_POST['password']));

        // Check credentials in the database
        $sql = "SELECT * FROM admin WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Set session variables
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['admin_logged_in'] = true; // Set logged in session
                header("Location: admin_index.php"); // Redirect to admin dashboard
                exit();
            } else {
                $error_message = "Invalid password.";
            }
        } else {
            $error_message = "No user found with that username.";
        }
    }
}

// Close connection
$conn->close();
?>
