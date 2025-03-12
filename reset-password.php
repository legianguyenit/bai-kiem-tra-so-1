<?php
    include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-100">
    <main class="flex flex-col items-center justify-center min-h-screen text-center px-6">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6">Reset Mật Khẩu</h2>
            <?php
                $errors = [];
                $successMessage = "";
                $email = "";
                $step = 1;

                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    if (isset($_POST['email'])) {
                        $email = htmlspecialchars($_POST['email']);
                        if (isset($_COOKIE['email']) && $_COOKIE['email'] == $email) {
                            $step = 2; 
                        } else {
                            $errors['email'] = "Email không tồn tại trong hệ thống.";
                        }
                    }
                    
                    if (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
                        $new_password = htmlspecialchars($_POST['new_password']);
                        $confirm_password = htmlspecialchars($_POST['confirm_password']);
                        
                        if (empty($new_password)) {
                            $errors['new_password'] = "Vui lòng nhập mật khẩu mới.";
                        } elseif (strlen($new_password) < 6) {
                            $errors['new_password'] = "Mật khẩu phải ít nhất 6 ký tự.";
                        }
                        
                        if ($new_password !== $confirm_password) {
                            $errors['confirm_password'] = "Mật khẩu xác nhận không khớp.";
                        }
                        
                        if (empty($errors)) {
                            setcookie("password", $new_password, time() + (86400 * 30), "/");
                            $successMessage = "Mật khẩu đã được cập nhật thành công!";
                        }
                    }
                }
            ?>

            <?php if ($step == 1): ?>
                <form action="reset-password.php" method="POST">
                    <div class="mb-4 text-left">
                        <label class="block text-gray-700">Nhập Email</label>
                        <input type="email" name="email" placeholder="Nhập email" value="<?php echo $email ?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <?php if (isset($errors['email'])): ?>
                            <div style='color: red;'><?php echo $errors['email']; ?></div>
                        <?php endif; ?>
                    </div>
                    <button class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">Tiếp tục</button>
                </form>
            <?php elseif ($step == 2): ?>
                <form action="reset-password.php" method="POST">
                    <div class="mb-4 text-left">
                        <label class="block text-gray-700">Mật khẩu mới</label>
                        <input type="password" name="new_password" placeholder="Nhập mật khẩu mới" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <?php if (isset($errors['new_password'])): ?>
                            <div style='color: red;'><?php echo $errors['new_password']; ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-4 text-left">
                        <label class="block text-gray-700">Xác nhận mật khẩu</label>
                        <input type="password" name="confirm_password" placeholder="Xác nhận mật khẩu" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <?php if (isset($errors['confirm_password'])): ?>
                            <div style='color: red;'><?php echo $errors['confirm_password']; ?></div>
                        <?php endif; ?>
                    </div>
                    <button class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">Đặt lại mật khẩu</button>
                </form>
            <?php endif; ?>

            <?php if ($successMessage): ?>
                <div class="mt-4 text-green-600"> <?php echo $successMessage; ?> </div>
                <div class="mt-2 text-sm">
                    <a href="login.php" class="text-blue-600 hover:underline">Đăng nhập</a>
                </div>
            <?php endif; ?>
        </div>
    </main>
<?php
    include 'includes/footer.php';
?>
</body>
</html>