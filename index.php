<?php
    include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Web Của Bạn</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<?php
    if (isset($_COOKIE['loggedin']) && $_COOKIE['loggedin'] == "true") {
        header("location: dashboard.php");
        exit();
    }
?>
<body class="bg-blue-100">
    <main class="flex flex-col items-center justify-center h-screen text-center px-6">
        <h2 class="text-2xl md:text-3xl font-bold">Chào Mừng Đến Với (tên trang web của bạn)</h2>
        <p class="text-gray-600 mt-4 text-sm md:text-base">Đây là nơi bạn có thể khám phá các dịch vụ tuyệt vời của chúng tôi. Hãy đăng ký hoặc đăng nhập để trải nghiệm ngay hôm nay!</p>
        <div class="mt-6 flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
            <button class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 w-full md:w-auto"><a href="register.php">Đăng Ký</a></button>
            <button class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 w-full md:w-auto"><a href="login.php">Đăng Nhập</a</button>
        </div>
    </main>
</body>
<?php
    include 'includes/footer.php';
?>
</body>
</html>