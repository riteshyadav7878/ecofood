<?php
session_start();
require('fpdf/fpdf.php'); // Include the FPDF library

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include your database connection file
include 'conn.php';

// Fetch order details
$order = null;
$itemsResult = null;
if (isset($_GET['order_id'])) {
    $orderId = $_GET['order_id'];

    // Fetch the order info
    $sql = "SELECT * FROM cart_order WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $orderResult = $stmt->get_result();
    $order = $orderResult->fetch_assoc();

    // Fetch the items in the order
    $sql = "SELECT * FROM order_cart WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $itemsResult = $stmt->get_result();
}

// Function to generate and download PDF
if (isset($_GET['action']) && $_GET['action'] == 'download_pdf' && $order) {
    // Create instance of FPDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Add title
    $pdf->Cell(190, 10, 'Order Details', 0, 1, 'C');

    // Add order details
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, 'Order ID: ' . $order['order_id'], 0, 1);
    $pdf->Cell(50, 10, 'Full Name: ' . $order['full_name'], 0, 1);
    $pdf->Cell(50, 10, 'Email: ' . $order['email'], 0, 1);
    $pdf->Cell(50, 10, 'Address: ' . $order['address'], 0, 1);
    $pdf->Cell(50, 10, 'City: ' . $order['city'], 0, 1);
    $pdf->Cell(50, 10, 'ZIP: ' . $order['zip'], 0, 1);
    $pdf->Cell(50, 10, 'Total: ₹' . $order['total'], 0, 1);
    $pdf->Cell(50, 10, 'Status: ' . $order['status'], 0, 1);
    $pdf->Cell(50, 10, 'Order Date: ' . $order['order_date'], 0, 1);

    // Add order items table
    $pdf->Ln(10);  // Line break
    $pdf->Cell(50, 10, 'Items:', 0, 1);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(30, 10, 'Product ID', 1);
    $pdf->Cell(70, 10, 'Product Title', 1);
    $pdf->Cell(30, 10, 'Price', 1);
    $pdf->Cell(20, 10, 'Quantity', 1);
    $pdf->Cell(30, 10, 'Total', 1);
    $pdf->Ln();

    // Add items data
    $pdf->SetFont('Arial', '', 12);
    while ($item = $itemsResult->fetch_assoc()) {
        $pdf->Cell(30, 10, $item['product_id'], 1);
        $pdf->Cell(70, 10, $item['product_title'], 1);
        $pdf->Cell(30, 10, '₹' . $item['price'], 1);
        $pdf->Cell(20, 10, $item['quantity'], 1);
        $pdf->Cell(30, 10, '₹' . $item['total'], 1);
        $pdf->Ln();
    }

    // Output the PDF to browser
    $pdf->Output();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Light background for the page */
        }
        .order-card {
            background-color: #ffffff; /* White background for the card */
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add shadow for depth */
            padding: 20px;
        }
        .order-card h5 {
            color: #007bff; /* Blue text for title */
        }
        .table thead th {
            background-color: #007bff;
            color: #ffffff;
        }
        .table tbody tr {
            background-color: #f8f9fa; /* Light background for table rows */
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .back-btn {
            margin-top: 20px;
        }
        .table td, .table th {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Order Details</h2>

    <?php if ($order): ?>
        <div class="order-card mb-5">
            <h5>Order Information</h5>
            <p><strong>Order ID:</strong> <?php echo $order['order_id']; ?></p>
            <p><strong>Full Name:</strong> <?php echo $order['full_name']; ?></p>
            <p><strong>Email:</strong> <?php echo $order['email']; ?></p>
            <p><strong>Address:</strong> <?php echo $order['address']; ?></p>
            <p><strong>City:</strong> <?php echo $order['city']; ?></p>
            <p><strong>ZIP:</strong> <?php echo $order['zip']; ?></p>
            <p><strong>Total:</strong> ₹<?php echo $order['total']; ?></p>
            <p><strong>Status:</strong> <?php echo $order['status']; ?></p>
            <p><strong>Order Date:</strong> <?php echo $order['order_date']; ?></p>
        </div>

        <h3 class="text-center">Items in this Order</h3>
        <div class="table-responsive mb-5">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Title</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = $itemsResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $item['product_id']; ?></td>
                            <td><?php echo $item['product_title']; ?></td>
                            <td><?php echo '₹' . $item['price']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo '₹' . $item['total']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <a href="?order_id=<?php echo $order['order_id']; ?>&action=download_pdf" class="btn btn-secondary btn-block back-btn">Download PDF</a>
        <a href="oo.php" class="btn btn-primary btn-block back-btn">Back to Orders</a>
    <?php else: ?>
        <p class="text-danger text-center">Order not found.</p>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the statement and connection
$stmt->close();
$conn->close();
?>
