<?php
    $servername = "localhost"; // hoặc IP server
    $username = "root"; // tên đăng nhập MySQL
    $password = ""; // mật khẩu
    $dbname = "project"; // tên cơ sở dữ liệu
    
    // Tạo kết nối
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }
?>
