<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include database connection
include 'conn.php';

// Check if the cart session exists and is not empty
$cart_empty = !isset($_SESSION['cart']) || empty($_SESSION['cart']);

// Handle PDF download
if (isset($_GET['action']) && $_GET['action'] == 'download_pdf') {
    generatePDF();
}

// Function to generate PDF using FPDF or TCPDF
function generatePDF() {
    require('fpdf/fpdf.php'); // Include the FPDF library

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    // Cart Summary Title
    $pdf->Cell(0, 10, 'Cart Summary', 0, 1, 'C');

    // Check if cart exists
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        $pdf->Cell(0, 10, 'Your cart is empty.', 0, 1);
    } else {
        // Table headers
        $pdf->Cell(40, 10, 'Product', 1);
        $pdf->Cell(40, 10, 'Price', 1);
        $pdf->Cell(40, 10, 'Quantity', 1);
        $pdf->Cell(40, 10, 'Total', 1);
        $pdf->Ln();

        // Cart data
        $total = 0;
        foreach ($_SESSION['cart'] as $id => $item) {
            $product_name = $item['title'];
            $price = $item['price'];
            $quantity = $item['quantity'];
            $subtotal = $price * $quantity;

            $pdf->Cell(40, 10, $product_name, 1);
            $pdf->Cell(40, 10, '$' . number_format($price, 2), 1);
            $pdf->Cell(40, 10, $quantity, 1);
            $pdf->Cell(40, 10, '$' . number_format($subtotal, 2), 1);
            $pdf->Ln();

            $total += $subtotal;
        }

        // Total row
        $pdf->Cell(120, 10, 'Total', 1);
        $pdf->Cell(40, 10, '$' . number_format($total, 2), 1);
    }

    // Output the PDF
    $pdf->Output('D', 'cart_summary.pdf'); // Force download
    exit();
}

$total = 0;
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart Summary - Ecofood HTML5 Templates</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/main.css" rel="stylesheet">
</head>
<body>

<header>
    <?php include 'Unavbar.php'; ?>
</header>

<section>
<div class="section primary-color-background">
<div class="container">
<div class="p-t-70 p-b-85">
<div class="heading-page-1">
<h3>Cart Summary</h3>
</div>
</div>
</div>
</div>
<div class="section border-bottom-grey">
<div class="container">
<div class="breadcrumb-1">
<ul>
<li><a href="shop-list-with-sidebar.php">Your Cart</a></li>
</ul>
</div>
</div>
</div>
</section>

<section>
    <div class="container mt-5">

        <?php if ($cart_empty): ?>
            <div class="alert alert-warning text-center" role="alert">
                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                <strong>No record found!</strong> Your cart is empty.
            </div>
            <div class="text-center mt-4">
                <a href="shop-list-without-sidebar.php" class="btn btn-primary btn-sm">
                    <i class="fa fa-shopping-cart"></i> Continue Shopping
                </a>
            </div>
        <?php else: ?>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                        <tr>
                            <td><img src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" width="50"></td>
                            <td><?php echo htmlspecialchars($item['title']); ?></td>
                            <td>$<?php echo htmlspecialchars($item['price']); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td>$<?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                            <?php $total += $item['price'] * $item['quantity']; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right font-weight-bold">Total</td>
                        <td class="font-weight-bold">$<?php echo $total; ?></td>
                    </tr>
                </tfoot>
            </table>

            <div class="text-center mt-4">
                <a href="?action=download_pdf" class="btn btn-secondary">
                    <i class="fa fa-file-pdf-o"></i> Download PDF
                </a>
                <a href="checkout.php" class="btn btn-success btn-lg">
                    Proceed to Checkout
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<footer>
    <?php include 'Footer.php'; ?>
</footer>

<!-- Bootstrap and jQuery JS -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
