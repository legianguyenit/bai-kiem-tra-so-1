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
    'total_products' => 0,
];

$product_query = "SELECT COUNT(*) AS total_products FROM products";
$product_result = mysqli_query($conn, $product_query);
if ($product_result && $row = mysqli_fetch_assoc($product_result)) {
    $response['total_products'] = (int) $row['total_products'];
}
echo json_encode($response);
?>
