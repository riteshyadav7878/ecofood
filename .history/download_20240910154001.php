<?php
session_start();

// Include your database connection file
include 'conn.php';

if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch user details
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$userResult = $stmt->get_result();
$user = $userResult->fetch_assoc();

$type = isset($_GET['type']) ? $_GET['type'] : '';

if ($type == 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=user_details.csv');

    $output = fopen('php://output', 'w');
    fputcsv($output, array('Username', 'Full Name', 'Email', 'Address', 'City', 'ZIP'));

    if ($user) {
        fputcsv($output, array(
            $user['username'],
            $user['full_name'],
            $user['email'],
            $user['address'],
            $user['city'],
            $user['zip']
        ));
    }
    fclose($output);
    exit();
} elseif ($type == 'pdf') {
    require('fpdf/fpdf.php'); // Ensure you have FPDF library included

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'User Details', 0, 1, 'C');

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Username: ' . $user['username'], 0, 1);
    $pdf->Cell(0, 10, 'Full Name: ' . $user['full_name'], 0, 1);
    $pdf->Cell(0, 10, 'Email: ' . $user['email'], 0, 1);
    $pdf->Cell(0, 10, 'Address: ' . $user['address'], 0, 1);
    $pdf->Cell(0, 10, 'City: ' . $user['city'], 0, 1);
    $pdf->Cell(0, 10, 'ZIP: ' . $user['zip'], 0, 1);

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment;filename=user_details.pdf');
    $pdf->Output('D');
    exit();
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
