<?php
    if (!isset($_COOKIE['loggedin'])) {
        header("location: ../login.php");
        exit();
    }
?>
<?php 
    session_start();
    include "../config/database.php"; 

    if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
        $_SESSION['error_message'] = "ID không hợp lệ!";
        header("Location: index.php");
        exit();
    }

    $id = (int) $_GET["id"];

    $check_id = "SELECT * FROM users WHERE id = $id";
    $result = $conn->query($check_id);

    if ($result->num_rows === 0) {
        $_SESSION['error_message'] = "ID người dùng không tồn tại!";
    } else {
        $delete_id = "DELETE FROM users WHERE id = $id";
        if ($conn->query($delete_id) === TRUE) {
            $_SESSION['success_message'] = "Xóa người dùng thành công!";
        } else {
            $_SESSION['error_message'] = "Lỗi khi xóa người dùng: " . $conn->error;
        }
    }

    header("Location: index.php");
    exit();
?>
