<?php
    include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<?php
    if (isset($_COOKIE['loggedin']) && $_COOKIE['loggedin'] == "true") {
        header("location: dashboard.php");
        exit();
    }
?>
<?php
    $errors_login = [];
    $errors = [];
    $email = $password = "";
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        // Kiểm tra email
        if (empty($email)) {
            $errors['email'] = "Vui lòng nhập email.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email không hợp lệ.";
        }

        // Kiểm tra mật khẩu
        if (empty($password)) {
            $errors['password'] = "Vui lòng nhập mật khẩu.";
        } elseif (strlen($password) < 6) {
            $errors['password'] = "Mật khẩu phải ít nhất 6 ký tự.";
        }

        // Nếu không có lỗi validation
        if (empty($errors)) {
            if (isset($_COOKIE["email"]) && isset($_COOKIE["password"])) {
                if ($_COOKIE["email"] == $email && $_COOKIE["password"] == $password) {
                    setcookie("loggedin", "true", time() + 3600, "/");
                    header("location: dashboard.php");
                    exit();
                } else {
                    if ($_COOKIE["email"] !== $email && $_COOKIE["password"] !== $password) {
                        $errors_login['common'] = "Email và mật khẩu không đúng.";
                    } elseif ($_COOKIE["email"] !== $email) {
                        $errors_login['email'] = "Email không chính xác.";
                    } elseif ($_COOKIE["password"] !== $password) {
                        $errors_login['password'] = "Mật khẩu không chính xác.";
                    }
                }
            } else {
                $errors_login['common'] = "Không tìm thấy thông tin đăng nhập.";
            }
        }
    }
?>

<body class="bg-blue-100"> 
    <main class="flex flex-col items-center justify-start min-h-screen text-center px-6 mt-20">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6">Đăng Nhập</h2>
            <?php
                if (isset($errors_login['common'])) {
                    echo "<div style='color: red;'>";
                    echo $errors_login['common'];
                    echo "</div>";
                }
            ?>
            <form action="login.php" method="POST">
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Email</label>
                    <input type="email" placeholder="Nhập email" name="email" value="<?php echo $email?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['email'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['email'];
                            echo "</div>";
                        } elseif (isset($errors_login['email'])) {
                            echo "<div style='color: red;'>";
                            echo $errors_login['email'];
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
                        } elseif (isset($errors_login['password'])) {
                            echo "<div style='color: red;'>";
                            echo $errors_login['password'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <button class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">Đăng Nhập</button>
            </form>
            <div class="mt-4 text-sm">
                Đã có tài khoản? <a href="register.php" class="text-blue-600 hover:underline">Đăng Ký</a>
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