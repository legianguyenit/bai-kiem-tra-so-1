<?php 
    session_start();
    include "../config/database.php"; 
?>
<?php
$id = $_GET["id"];
$sql = "DELETE FROM users WHERE id=$id";
$conn->query($sql);
$_SESSION['error_message'] = "Xóa người dùng thành công!";
header("Location: index.php");
?>