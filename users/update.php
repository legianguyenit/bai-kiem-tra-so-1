<?php
session_start();
include '../includes/header.php';
include '../config/database.php';

$errors = [];
$user = [];
$is_edit = false;

// Kiểm tra chế độ chỉnh sửa
if (isset($_GET['id'])) {
    $is_edit = true;
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM users WHERE id = $id");
    $user = $result->fetch_assoc();
    
    if (!$user) {
        $_SESSION['error_message'] = "Người dùng không tồn tại!";
        header("Location: index.php");
        exit();
    }
}

// Xử lý dữ liệu form
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $fullname = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $confirm_password = htmlspecialchars($_POST['confirm_password']);

    // Validation
    if (empty($fullname)) {
        $errors['fullname'] = "Vui lòng nhập họ tên.";
    }

    if (empty($email)) {
        $errors['email'] = "Vui lòng nhập email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email không hợp lệ.";
    }

    // Xử lý riêng cho chế độ thêm mới
    if (!$is_edit) {
        if (empty($password)) {
            $errors['password'] = "Vui lòng nhập mật khẩu.";
        } elseif (strlen($password) < 6) {
            $errors['password'] = "Mật khẩu phải ít nhất 6 ký tự.";
        }

        if (empty($confirm_password)) {
            $errors['confirm_password'] = "Vui lòng xác nhận mật khẩu.";
        } elseif ($password !== $confirm_password) {
            $errors['confirm_password'] = "Mật khẩu xác nhận không khớp.";
        }
    }

    // Kiểm tra email trùng
    $sql = "SELECT id FROM users WHERE email = '$email'";
    if ($is_edit) {
        $sql .= " AND id != $id";
    }
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $errors['email'] = "Email đã được sử dụng.";
    }

    // Xử lý lưu dữ liệu
    if (empty($errors)) {
        if ($is_edit) {
            // Cập nhật người dùng
            $sql = "UPDATE users SET fullname = '$fullname', email = '$email'";
            
            // Nếu có mật khẩu mới
            if (!empty($password)) {
                if (strlen($password) < 6) {
                    $errors['password'] = "Mật khẩu phải ít nhất 6 ký tự.";
                } elseif ($password !== $confirm_password) {
                    $errors['confirm_password'] = "Mật khẩu xác nhận không khớp.";
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $sql .= ", password = '$hashed_password'";
                }
            }
            
            $sql .= " WHERE id = $id";
            
            if ($conn->query($sql)) {
                $_SESSION['success_message'] = "Cập nhật người dùng thành công!";
                header("Location: index.php");
                exit();
            } else {
                $errors['database'] = "Lỗi cập nhật: " . $conn->error;
            }
        } else {
            // Thêm người dùng mới
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (fullname, email, password) 
                    VALUES ('$fullname', '$email', '$hashed_password')";
            
            if ($conn->query($sql)) {
                $_SESSION['success_message'] = "Thêm người dùng thành công!";
                header("Location: index.php");
                exit();
            } else {
                $errors['database'] = "Lỗi thêm mới: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $is_edit ? 'Cập nhật' : 'Thêm'; ?> người dùng</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-100">
    <main class="flex flex-col items-center justify-start min-h-screen text-center px-6 mt-20">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6">
                <?php echo $is_edit ? 'Cập nhật người dùng' : 'Thêm người dùng'; ?>
            </h2>
            
            <?php if (!empty($errors['database'])): ?>
                <div class="mb-4 text-red-500">
                    <?php echo $errors['database']; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Họ và tên</label>
                    <input type="text" name="fullname" 
                           value="<?php echo $is_edit ? $user['fullname'] : ($fullname ?? ''); ?>"
                           class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php if (isset($errors['fullname'])): ?>
                        <div class="text-red-500 text-sm"><?php echo $errors['fullname']; ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Email</label>
                    <input type="email" name="email" 
                           value="<?php echo $is_edit ? $user['email'] : ($email ?? ''); ?>"
                           class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php if (isset($errors['email'])): ?>
                        <div class="text-red-500 text-sm"><?php echo $errors['email']; ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Mật khẩu <?php echo $is_edit ? '(Để trống nếu không đổi)' : ''; ?></label>
                    <input type="password" name="password" 
                           class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php if (isset($errors['password'])): ?>
                        <div class="text-red-500 text-sm"><?php echo $errors['password']; ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Xác nhận mật khẩu</label>
                    <input type="password" name="confirm_password" 
                           class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php if (isset($errors['confirm_password'])): ?>
                        <div class="text-red-500 text-sm"><?php echo $errors['confirm_password']; ?></div>
                    <?php endif; ?> 
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">
                        <?php echo $is_edit ? 'Cập nhật' : 'Thêm'; ?>
                    </button>
                    <a href="index.php" class="w-full bg-gray-600 text-white py-2 rounded-md hover:bg-gray-700 text-center">
                        Hủy
                    </a>
                </div>
            </form>
        </div>
    </main>
    
    <?php include '../includes/footer.php'; ?>
</body>
</html>