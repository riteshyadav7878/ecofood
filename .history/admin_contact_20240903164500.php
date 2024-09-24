<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php"); // Redirect to login page
    exit();
}

// Include database connection file
include 'conn.php';

include  'admin.'

// Handle deletion request
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Prepare the SQL statement to delete the record
    $sql = "DELETE FROM contact_submissions WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    // Execute the query and redirect based on success or failure
    if ($stmt->execute()) {
        $message = 'deleted';
    } else {
        $message = 'error';
    }
    $stmt->close();

    // Redirect to the same page with a message
    header("Location: admin_contact.php?message=$message");
    exit();
}

// Fetch contact submissions from the database
$sql = "SELECT * FROM contact_submissions";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Contact Submissions</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Contact Submissions</h1>
        <?php
        // Display success or error messages
        if (isset($_GET['message'])) {
            if ($_GET['message'] == 'deleted') {
                echo '<div class="alert alert-success">Submission deleted successfully.</div>';
            } elseif ($_GET['message'] == 'error') {
                echo '<div class="alert alert-danger">Error deleting submission.</div>';
            }
        }

        if (mysqli_num_rows($result) > 0) {
            echo '<table class="table table-striped">';
            echo '<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Message</th><th>Actions</th></tr></thead>';
            echo '<tbody>';

            // Output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                echo '<td>' . htmlspecialchars($row['message']) . '</td>';
                echo '<td>
                        <a href="admin_contact.php?action=delete&id=' . htmlspecialchars($row['id']) . '" class="btn btn-danger btn-sm">Delete</a>
                      </td>';
                echo '</tr>';
            }
            
            echo '</tbody></table>';
        } else {
            echo '<p>No submissions found.</p>';
        }
        ?>

        <!-- Add any additional admin functionalities here -->

    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
