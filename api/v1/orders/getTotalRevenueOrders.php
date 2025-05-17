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
    'total_revenue' => 0,
];

// Tổng doanh thu từ đơn hàng đã nhận
$revenue_query = "SELECT SUM(total_amount) AS total_revenue FROM orders WHERE status = 'da_nhan_hang'";
$revenue_result = mysqli_query($conn, $revenue_query);
if ($revenue_result && $row = mysqli_fetch_assoc($revenue_result)) {
    $response['total_revenue'] = (float) $row['total_revenue'];
}

echo json_encode($response);
?>
