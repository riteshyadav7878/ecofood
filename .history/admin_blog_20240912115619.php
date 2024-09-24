<?php
session_start();

// Check if user is logged in as admin (replace with your authentication logic)
if (!isset($_SESSION['admin_logged_in'])) {
  header('Location: login.php');
  exit;
}

// Include database connection
require_once 'db_connect.php';

// Handle image upload (if form submitted)
if (isset($_POST['upload'])) {
  $image_path = uploadImage($_FILES['image']); // Replace with your upload function
  $description = $_POST['description'];

  // Insert image data into database
  $sql = "INSERT INTO images (image_path, description) VALUES (?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ss', $image_path, $description);
  $stmt->execute();

  // Handle success or error message (replace with your display logic)
  if ($stmt->affected_rows === 1) {
    $message = "Image uploaded successfully!";
  } else {
    $message = "Error uploading image.";
  }
}

// Handle image update (if form submitted)
if (isset($_POST['update'])) {
  $id = intval($_POST['id']);
  $description = $_POST['description'];

  // Update image description in database
  $sql = "UPDATE images SET description = ? WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('si', $description, $id);
  $stmt->execute();

  // Handle success or error message (replace with your display logic)
  if ($stmt->affected_rows === 1) {
    $message = "Image description updated successfully!";
  } else {
    $message = "Error updating image description.";
  }
}

// Handle image deletion (if form submitted)
if (isset($_POST['delete'])) {
  $id = intval($_POST['id']);

  // Delete image from database and potentially file system (replace with your deletion logic)
  $sql = "DELETE FROM images WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $id);
  $stmt->execute();

  // Handle success or error message (replace with your display logic)
  if ($stmt->affected_rows === 1) {
    $message = "Image deleted successfully!";
  } else {
    $message = "Error deleting image.";
  }
}

// Retrieve all images from database
$sql = "SELECT id, image_path, description FROM images";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Display images in admin panel (replace with your desired layout)
while ($row = $result->fetch_assoc()) {
  echo "<div class='image-item'>";
  echo "<img src='" . $row['image_path'] . "'>";
  echo "<p>Description: " . $row['description'] . "</p>";
  echo "<form method='post' action='admin_panel.php'>";
  echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
  echo "<input type='text' name='description' value='" . $row['description'] . "'>";
  echo "<button type='submit' name='update'>Update</button>";
  echo "<button type='submit' name='delete' onclick='return confirm(\"Are you sure you want to delete this image?\")'>Delete</button>";
  echo "</form>";
  echo "</div>";
}

$conn->close();
?>