<?php
    include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Mật Khẩu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<?php
    $errors = [];
    $step = 1; // Mặc định bước đầu tiên
    $email = $new_password = $confirm_password = "";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['step']) && $_POST['step'] == "1") {
            // Bước 1: Kiểm tra email
            $email = htmlspecialchars($_POST['email']);
            if (empty($email)) {
                $errors['email'] = "Vui lòng nhập email.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Email không hợp lệ.";
            } elseif (!isset($_COOKIE['email']) || $_COOKIE['email'] !== $email) {
                $errors['email'] = "Email không tồn tại trong hệ thống.";
            } else {
                $step = 2; // Chuyển sang bước 2 nếu email hợp lệ
            }
        } elseif (isset($_POST['step']) && $_POST['step'] == "2") {
            // Bước 2: Kiểm tra và cập nhật mật khẩu mới
            $new_password = htmlspecialchars($_POST['new_password']);
            $confirm_password = htmlspecialchars($_POST['confirm_password']);

            if (empty($new_password)) {
                $errors['new_password'] = "Vui lòng nhập mật khẩu mới.";
            } elseif (strlen($new_password) < 6) {
                $errors['new_password'] = "Mật khẩu mới phải ít nhất 6 ký tự.";
            }

            if (empty($confirm_password)) {
                $errors['confirm_password'] = "Vui lòng xác nhận mật khẩu.";
            } elseif ($new_password !== $confirm_password) {
                $errors['confirm_password'] = "Xác nhận mật khẩu không khớp.";
            }

            if (empty($errors)) {
                setcookie("password", $new_password, time() + (86400 * 30), "/"); // Cập nhật mật khẩu mới
                header("Location: login.php"); // Chuyển hướng về trang đăng nhập
                exit;
            } else {
                $step = 2; // Hiển thị lại bước 2 nếu có lỗi
            }
        }
    }
?>
<body class="bg-blue-100">
    <main class="flex flex-col items-center justify-center min-h-screen text-center px-6">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6">Đặt Lại Mật Khẩu</h2>

            <?php if ($step == 1): ?>
                <!-- Bước 1: Nhập email -->
                <form action="reset-password.php" method="POST">
                    <input type="hidden" name="step" value="1">
                    <div class="mb-4 text-left">
                        <label class="block text-gray-700">Nhập Email</label>
                        <input type="email" name="email" value="<?php echo $email ?>" 
                            placeholder="Nhập email của bạn" 
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <?php if (isset($errors['email'])): ?>
                            <div style="color: red;"><?php echo $errors['email']; ?></div>
                        <?php endif; ?>
                    </div>
                    <button class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">Tiếp Tục</button>
                </form>

            <?php elseif ($step == 2): ?>
                <!-- Bước 2: Nhập mật khẩu mới -->
                <form action="reset-password.php" method="POST">
                    <input type="hidden" name="step" value="2">
                    <div class="mb-4 text-left">
                        <label class="block text-gray-700">Mật khẩu mới</label>
                        <input type="password" name="new_password" 
                            placeholder="Nhập mật khẩu mới" 
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <?php if (isset($errors['new_password'])): ?>
                            <div style="color: red;"><?php echo $errors['new_password']; ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-4 text-left">
                        <label class="block text-gray-700">Xác nhận mật khẩu mới</label>
                        <input type="password" name="confirm_password" 
                            placeholder="Xác nhận mật khẩu mới" 
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <?php if (isset($errors['confirm_password'])): ?>
                            <div style="color: red;"><?php echo $errors['confirm_password']; ?></div>
                        <?php endif; ?>
                    </div>
                    <button class="w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700">Đặt Lại Mật Khẩu</button>
                </form>
            <?php endif; ?>

            <div class="mt-4 text-sm">
                <a href="login.php" class="text-blue-600 hover:underline">Quay lại Đăng Nhập</a>
            </div>
        </div>
    </main>
<?php
    include 'includes/footer.php';
?>
</body>
</html>
