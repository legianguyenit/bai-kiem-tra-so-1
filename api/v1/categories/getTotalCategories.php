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
    'total_categories' => 0
];

$category_query = "SELECT COUNT(*) AS total_categories FROM categories";
$category_result = mysqli_query($conn, $category_query);
if ($category_result && $row = mysqli_fetch_assoc($category_result)) {
    $response['total_categories'] = (int) $row['total_categories'];
}

echo json_encode($response);
?>
