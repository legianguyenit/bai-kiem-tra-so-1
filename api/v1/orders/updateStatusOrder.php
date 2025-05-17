<?php
if (!isset($_COOKIE['loggedin'])) {
    header("Location: ../../../login.php");
    exit();
}

session_start();
include '../../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = (int)$_POST['order_id'];
    $status   = mysqli_real_escape_string($conn, $_POST['status']);

    // Kiểm tra status hợp lệ
    $allowed = ['cho_xac_nhan','dang_van_chuyen','thanh_toan_thanh_cong','da_nhan_hang'];
    if (in_array($status, $allowed, true)) {
        $sql = "UPDATE orders 
                SET status = '$status', updated_at = NOW() 
                WHERE id = $order_id";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['success_message'] = "Cập nhật trạng thái thành công.";
        } else {
            $_SESSION['error_message']   = "Lỗi cập nhật: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['error_message'] = "Trạng thái không hợp lệ.";
    }
}

header("Location: ../../../orders/index.php");
exit();
