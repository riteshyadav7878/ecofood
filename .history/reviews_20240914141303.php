<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews Management</title>
    <link rel="stylesheet" href="path/to/bootstrap.min.css"> <!-- Ensure Bootstrap CSS is linked -->
    <style>
        /* Applying a gradient background */
        body {
            background: linear-gradient(to right, #4facfe, #00f2fe); /* Light blue gradient */
            min-height: 100vh; /* Ensure the background covers the full viewport height */
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: white; /* White background for content */
            padding: 30px;
            border-radius: 10px; /* Rounded corners */
            margin-top: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }

        h1 {
            color: #333; /* Dark text for contrast */
            text-align: center;
            margin-bottom: 30px;
        }

        .table-container {
            margin-top: 20px;
            overflow-x: auto; /* Enable horizontal scrolling on small screens */
        }

        /* Table styling */
        table.table {
            width: 100%; /* Ensure the table takes full width */
            border-collapse: collapse; /* Merge table borders */
        }

        table.table th, table.table td {
            padding: 12px; /* Padding inside cells */
            text-align: left; /* Left align text */
        }

        table.table th {
            background-color: #00c6ff; /* Blue background for table headers */
            color: white; /* White text for headers */
        }

        table.table tr:nth-child(even) {
            background-color: #f2f2f2; /* Light grey for alternating rows */
        }

        .btn-danger {
            background-color: #ff5f6d; /* Light red color for delete button */
            border-color: #ff5f6d;
        }

        /* Responsive for mobile */
        @media (max-width: 768px) {
            .container {
                padding: 15px; /* Adjust padding for smaller screens */
            }

            h1 {
                font-size: 1.5rem; /* Smaller heading on mobile */
            }

            table.table th, table.table td {
                padding: 8px; /* Smaller padding for table cells */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>All Reviews</h1>
        <div class="table-container">
            <?php
            if (mysqli_num_rows($review_result) > 0) {
                echo '<table class="table table-striped table-responsive">';
                echo '<thead><tr><th>Product</th><th>Reviewer Name</th><th>Review</th><th>Actions</th></tr></thead>';
                echo '<tbody>';
                while ($review = mysqli_fetch_assoc($review_result)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($review['product_title']) . '</td>';
                    echo '<td>' . htmlspecialchars($review['reviewer_name']) . '</td>';
                    echo '<td>' . htmlspecialchars($review['review_text']) . '</td>';
                    echo '<td><a href="reviews.php?delete_id=' . $review['id'] . '" class="btn btn-danger btn-sm">Delete</a></td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p>No reviews available.</p>';
            }
            ?>
        </div>
    </div>
    <script src="path/to/bootstrap.bundle.min.js"></script> <!-- Ensure Bootstrap JS is linked -->
</body>
</html>
