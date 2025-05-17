<?php
    if (!isset($_COOKIE['loggedin'])) {
        header("location: ../login.php");
        exit();
    }
?>

<?php 
    session_start();
    include "../config/database.php"; 

    if (!isset($_GET["product_code"]) || empty($_GET["product_code"])) {
        $_SESSION['error_message'] = "Mã sản phẩm không hợp lệ!";
        header("Location: index.php");
        exit();
    }

    $product_code = mysqli_real_escape_string($conn, $_GET["product_code"]);

    $check_product_code = "SELECT * FROM products WHERE product_code = '$product_code'";
    $result = $conn->query($check_product_code);

    if ($result->num_rows === 0) {
        $_SESSION['error_message'] = "Mã sản phẩm không tồn tại!";
    } else {
        $delete_id = "DELETE FROM products WHERE product_code = '$product_code'";
        if ($conn->query($delete_id) === TRUE) {
            $_SESSION['success_message'] = "Xóa sản phẩm thành công!";
        } else {
            $_SESSION['error_message'] = "Lỗi khi xóa sản phẩm: " . $conn->error;
        }
    }

    header("Location: index.php");
    exit();
?>
