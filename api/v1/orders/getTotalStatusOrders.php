<?php
if (!isset($_COOKIE['loggedin'])) {
    header("location: ../../../login.php");
    exit();
}
?>

<?php
header('Content-Type: application/json');
include '../../../config/database.php';

$response = [
    'total_cho_xac_nhan' => 0,
    'total_da_nhan_hang' => 0,
];


// Tổng đơn hàng có status = 'cho_xac_nhan'
$pending_query = "SELECT COUNT(*) AS total_cho_xac_nhan FROM orders WHERE status = 'cho_xac_nhan'";
$pending_result = mysqli_query($conn, $pending_query);
if ($pending_result && $row = mysqli_fetch_assoc($pending_result)) {
    $response['total_cho_xac_nhan'] = (int) $row['total_cho_xac_nhan'];
}

// Tổng đơn hàng có status = 'da_nhan_hang'
$received_query = "SELECT COUNT(*) AS total_da_nhan_hang FROM orders WHERE status = 'da_nhan_hang'";
$received_result = mysqli_query($conn, $received_query);
if ($received_result && $row = mysqli_fetch_assoc($received_result)) {
    $response['total_da_nhan_hang'] = (int) $row['total_da_nhan_hang'];
}

echo json_encode($response);
?>
