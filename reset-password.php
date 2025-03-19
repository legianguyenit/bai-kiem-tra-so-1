<?php
    include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<?php
    if (isset($_COOKIE['loggedin']) && $_COOKIE['loggedin'] == "true") {
        header("location: dashboard.php");
        exit();
    }
?>

<?php
$errors = [];
$reset_success = "";
$email = "";
$reset_password = "";
$confirm_reset_password = "";
$show_reset_password_form = false;
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['email'])) {
        $email = htmlspecialchars(trim($_POST['email']));
        if (empty($email)) {
            $errors['email'] = "Vui lòng nhập email.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email không hợp lệ.";
        } else {
            if (isset($_COOKIE['email']) && $_COOKIE['email'] === $email) {
                $show_reset_password_form = true;
            } else {
                $errors['email'] = "Email không tồn tại.";
            }
        }
    }
    elseif (isset($_POST['reset_password']) && isset($_POST['confirm_reset_password'])) {
        $reset_password = htmlspecialchars(trim($_POST['reset_password']));
        $confirm_reset_password = htmlspecialchars(trim($_POST['confirm_reset_password']));

        if (empty($reset_password)) {
            $errors['reset_password'] = "Vui lòng nhập mật khẩu.";
        } elseif (strlen($reset_password) < 6) {
            $errors['reset_password'] = "Mật khẩu phải ít nhất 6 ký tự.";
        }

        if (empty($confirm_reset_password)) {
            $errors['confirm_reset_password'] = "Vui lòng xác nhận mật khẩu.";
        } elseif ($reset_password !== $confirm_reset_password) {
            $errors['confirm_reset_password'] = "Mật khẩu xác nhận không khớp.";
        }

        if (empty($errors)) {
            $reset_success = $_COOKIE['email'] . ". Đã đặt lại mật khẩu thành công!";
            setcookie("password", $reset_password, time() + (86400 * 30), "/");
        }
        $show_reset_password_form = true;   
    }
}
?>

<body class="bg-blue-100"> 
    <main class="flex flex-col items-center justify-start min-h-screen text-center px-6 mt-20">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6">Đặt Lại Mật Khẩu</h2>
                <?php
                    if (!empty($reset_success)) {
                        echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md">
                                <p>' . htmlspecialchars($reset_success) . '</p>
                            </div>';
                    }
                ?>
                <?php
                    if ($show_reset_password_form) {
                ?> 
                    <form action="reset-password.php" method="POST">
                        <div class="mb-4 text-left">
                            <label class="block text-gray-700">Mật khẩu</label>
                            <input type="password" placeholder="Nhập mật khẩu" name="reset_password" value="<?php echo $reset_password; ?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <?php
                                if (isset($errors['reset_password'])) {
                                    echo "<div style='color: red;'>";
                                    echo $errors['reset_password'];
                                    echo "</div>";
                                }
                            ?>
                        </div>
                        <div class="mb-4 text-left">
                            <label class="block text-gray-700">Xác nhận mật khẩu</label>
                            <input type="password" placeholder="Xác nhận mật khẩu" name="confirm_reset_password" value="<?php echo $confirm_reset_password; ?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <?php
                                if (isset($errors['confirm_reset_password'])) {
                                    echo "<div style='color: red;'>";
                                    echo $errors['confirm_reset_password'];
                                    echo "</div>";
                                }
                            ?>
                        </div>
                        <button class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">Gửi yêu cầu</button>
                    </form>
                    <div class="mt-4 text-sm">Đã có tài khoản? <a href="login.php" class="text-blue-600 hover:underline">Đăng Nhập</a></div>
                <?php
                    } else {
                ?> 
                    <form action="reset-password.php" method="POST">
                        <div class="mb-4 text-left">
                            <label class="block text-gray-700">Email</label>
                            <input type="email" placeholder="Nhập email" name="email" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <?php
                                if (isset($errors['email'])) {
                                    echo "<div style='color: red;'>";
                                    echo $errors['email'];
                                    echo "</div>";
                                }
                            ?>
                        </div>
                        <button class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">Gửi yêu cầu</button>
                    </form>
            <?php
                }
            ?>
        </div>  
    </main>
<?php
    include 'includes/footer.php';
?>
</body>
</html>