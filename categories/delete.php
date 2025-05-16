<?php
    if (!isset($_COOKIE['loggedin'])) {
        header("location: ../login.php");
        exit();
    }
?>

<?php 
    session_start();
    include "../config/database.php"; 

    if (!isset($_GET["categories_code"]) || empty($_GET["categories_code"])) {
        $_SESSION['error_message'] = "Mã danh mục không hợp lệ!";
        header("Location: index.php");
        exit();
    }

    $categories_code = mysqli_real_escape_string($conn, $_GET["categories_code"]);

    $check_categories_code = "SELECT * FROM categories WHERE categories_code = '$categories_code'";
    $result = $conn->query($check_categories_code);

    if ($result->num_rows === 0) {
        $_SESSION['error_message'] = "Mã danh mục không tồn tại!";
    } else {
        // Xóa danh mục
        $delete_id = "DELETE FROM categories WHERE categories_code = '$categories_code'";
        if ($conn->query($delete_id) === TRUE) {
            $_SESSION['success_message'] = "Xóa danh mục thành công!";
        } else {
            $_SESSION['error_message'] = "Lỗi khi xóa danh mục: " . $conn->error;
        }
    }

    header("Location: index.php");
    exit();
?>
