<?php
    if (!isset($_COOKIE['loggedin'])) {
        header("location: ../login.php");
        exit();
    }
?>
<?php
    session_start();
    include '../config/database.php';
?>
<?php
    if (!isset($_GET['id'])) {
        header('location:index.php');
    }

    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = '$id'";

    $result = mysqli_query($conn, $sql);
    $user_data = $result->fetch_assoc();
    if (empty($user_data)) {
        $_SESSION['error_message'] = "Id người dùng không tồn tại!";
        header("Location:index.php");
    }

    $old_avatar = $user_data['avatar'];
?>
<?php
    $errors = [];
    $fullname = $email = $password = $confirm_password = $role = "";
    $avatar = $old_avatar;

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $fullname = htmlspecialchars($_POST['fullname']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $confirm_password = htmlspecialchars($_POST['confirm_password']);
        $role = htmlspecialchars($_POST['role']);

        // Xử lý upload avatar mới
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
            $targetDir = "../assets/images/avatar/";
            $avatarName = time() . "_" . basename($_FILES["avatar"]["name"]);
            $targetFile = $targetDir . $avatarName;
            
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($imageFileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $targetFile)) {
                    $avatar = $avatarName; // Cập nhật avatar mới
                } else {
                    $errors['avatar'] = "Lỗi khi tải lên ảnh.";
                }
            } else {
                $errors['avatar'] = "Chỉ hỗ trợ các định dạng ảnh JPG, JPEG, PNG, GIF.";
            }
        }

        if (empty($old_avatar) && empty($avatar)) {
            $errors['avatar'] = "Vui lòng không để trống Avatar.";
        }

        if (empty($fullname)) {
            $errors['fullname'] = "Vui lòng nhập họ tên.";
        }

        if (empty($email)) {
            $errors['email'] = "Vui lòng nhập email.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email không hợp lệ.";
        }

        if (empty($_POST['role'])) {
            $errors['role'] = "Vui lòng chọn vai trò.";
        } elseif (!in_array($_POST['role'], ['admin', 'seller'])) {
            $errors['role'] = "Vai trò không hợp lệ.";
        }

        // Xử lý mật khẩu chỉ khi có nhập
        $password_update = '';
        if (!empty($password)) {
            if ($password !== $confirm_password) {
                $errors['confirm_password'] = "Mật khẩu xác nhận không khớp.";
            } else {
                $password_update = ", password = '" . password_hash($password, PASSWORD_DEFAULT) . "'";
            }
        }

        if (empty($errors)) {
            $sql_check_email = "SELECT * FROM users WHERE email = '$email' AND id != '$id'";
            $result = $conn->query($sql_check_email);

            if ($result->num_rows > 0) {
                $errors['email'] = "Email đã được sử dụng.";
            } else {
                $sql = "UPDATE users SET fullname = '$fullname', email = '$email', avatar = '$avatar', role = '$role' $password_update WHERE id = '$id'";

                if ($conn->query($sql) === TRUE) {
                    $_SESSION['success_message'] = "Cập nhật người dùng thành công!";
                    header("Location: index.php");
                    exit();
                } else {
                    echo "🔴 Lỗi: " . $conn->error;
                }
            }
        }
    }
?>
<?php
    include '../includes/header.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật người dùng</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-100"> 
    <main class="flex flex-col items-center justify-start min-h-screen text-center px-6 mt-20">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6">Cập nhật người dùng</h2> 
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Họ và tên</label>
                    <input type="text" placeholder="Nhập họ tên" name="fullname" value="<?php echo htmlspecialchars($user_data["fullname"]); ?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['fullname'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['fullname'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Email</label>
                    <input type="email" placeholder="Nhập email" name="email" value="<?php echo htmlspecialchars($user_data["email"]); ?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['email'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['email'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Mật khẩu mới (Để trống nếu không đổi)</label>
                    <input type="password" placeholder="Nhập mật khẩu" name="password" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Xác nhận mật khẩu mới</label>
                    <input type="password" placeholder="Xác nhận mật khẩu" name="confirm_password" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['confirm_password'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['confirm_password'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Vai trò người dùng</label>
                    <select name="role" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Chọn vai trò --</option>
                        <option value="admin" <?= (isset($role) && $role === 'admin') ? 'selected' : '' ?>>Admin</option>
                        <option value="seller" <?= (isset($role) && $role === 'seller') ? 'selected' : '' ?>>Seller</option>
                    </select>

                    <?php
                        if (isset($errors['role'])) {
                            echo "<div style='color: red;'>" . $errors['role'] . "</div>";
                        }
                    ?>
                </div>
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Avatar (Hiện tại: <?php echo $old_avatar ?>)</label>
                    <input type="file" name="avatar" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['avatar'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['avatar'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <button class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">Cập nhật</button>
            </form>
        </div>  
    </main>
<?php
    include '../includes/footer.php';
?>
</body>
</html>