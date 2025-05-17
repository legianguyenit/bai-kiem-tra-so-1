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
    'total_users' => 0,
];

$user_query = "SELECT COUNT(*) AS total_users FROM users";
$user_result = mysqli_query($conn, $user_query);
if ($user_result && $row = mysqli_fetch_assoc($user_result)) {
    $response['total_users'] = (int) $row['total_users'];
}
echo json_encode($response);
?>
