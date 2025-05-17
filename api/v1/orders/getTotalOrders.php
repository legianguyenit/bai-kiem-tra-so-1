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
    'total_orders' => 0,
];

$product_query = "SELECT COUNT(*) AS total_orders FROM orders";
$product_result = mysqli_query($conn, $product_query);
if ($product_result && $row = mysqli_fetch_assoc($product_result)) {
    $response['total_orders'] = (int) $row['total_orders'];
}
echo json_encode($response);
?>
