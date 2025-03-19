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
    $fullname = $email = $password = $confirm_password = "";
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $fullname = htmlspecialchars($_POST['fullname']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $confirm_password = htmlspecialchars($_POST['confirm_password']);

        if (empty($fullname)) {
            $errors['fullname'] = "Vui lòng nhập họ tên.";
        }

        if (empty($email)) {
            $errors['email'] = "Vui lòng nhập email.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email không hợp lệ.";
        }

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

        if (empty($errors)) {
            setcookie("fullname", $fullname, time() + (86400 * 30), "/");
            setcookie("email", $email, time() + (86400 * 30), "/");
            setcookie("password", $password, time() + (86400 * 30), "/");
            
            header("location: login.php");
            exit();
        }
    }
?>

<body class="bg-blue-100"> 
    <main class="flex flex-col items-center justify-start min-h-screen text-center px-6 mt-20">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6">Đăng Ký</h2>
            <form action="register.php" method="POST">
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Họ và tên</label>
                    <input type="text" placeholder="Nhập họ tên" name="fullname" value="<?php echo $fullname?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                    <input type="email" placeholder="Nhập email" name="email" value="<?php echo $email?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['email'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['email'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Mật khẩu</label>
                    <input type="password" placeholder="Nhập mật khẩu" name="password" value="<?php echo $password?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['password'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['password'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Xác nhận mật khẩu</label>
                    <input type="password" placeholder="Xác nhận mật khẩu" name="confirm_password" value="<?php echo $confirm_password?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['confirm_password'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['confirm_password'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <button class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">Đăng Ký</button>
            </form>
            <div class="mt-4 text-sm">
                Đã có tài khoản? <a href="login.php" class="text-blue-600 hover:underline">Đăng Nhập</a>
            </div>
            <div class="mt-2 text-sm">
                <a href="reset-password.php" class="text-blue-600 hover:underline">Quên mật khẩu?</a>
            </div>
        </div>  
    </main>
<?php
    include 'includes/footer.php';
?>
</body>
</html>