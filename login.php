<?php
    session_start();
    include 'includes/header.php';
    include 'config/database.php';
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
    $successMessage = '';
    if (isset($_SESSION['success_message'])) {
        $successMessage = $_SESSION['success_message'];
        unset($_SESSION['success_message']);
    }
?>
<?php
    $errors_login = [];
    $errors = [];
    $email = $password = "";
    
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
    
        // Kiểm tra email và password
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
    
        if (empty($errors)) {
            // Truy vấn lấy thông tin người dùng dựa trên email
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $userResult  = $conn->query($sql);
        
            // Kiểm tra xem email có tồn tại không
            if ($userResult->num_rows === 0) {
                $errors['email'] = "Email không tồn tại.";
            } else {
                // Lấy dữ liệu người dùng từ truy vấn
                $userData = $userResult->fetch_assoc();
        
                // Xác thực mật khẩu
                if (!password_verify($password, $userData['password'])) {
                    $errors['password'] = "Mật khẩu không đúng.";
                } else {
                    setcookie("loggedin", "true", time() + (86400 * 30), "/"); // Cookie hết hạn sau 30 ngày
                    setcookie("fullname", $userData['fullname'], time() + (86400 * 30), "/");
                    header("location: dashboard.php");
                    exit();
                }
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
                
                if (!empty($successMessage)): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
                        <strong class="font-bold">Đăng ký thành công! </strong>
                        <span class="block sm:inline"><?php echo htmlspecialchars($successMessage); ?></span>
                    </div>
                <?php endif;            
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