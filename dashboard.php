<?php
    session_start();
    if (!isset($_COOKIE['loggedin'])) {
        header("Location: login.php");
        exit();
    }
    include 'config/database.php';
    include 'includes/header.php';
?>
<?php
    if (isset($_COOKIE['products']) && !empty($_COOKIE['products'])) {
        // Giải mã JSON từ cookie 'products'
        $products = json_decode($_COOKIE['products'], true);

        // Kiểm tra nếu việc giải mã thành công và mảng không rỗng
        if ($products && is_array($products)) {
            // Đếm số lượng sản phẩm trong mảng
            $products_count = count($products);
        } else {
            $products_count = 0;
        }
    } else {
        // Nếu cookie không tồn tại hoặc không có giá trị hợp lệ
        $products_count = 0;
    }
    $logged_in_count = isset($_COOKIE['loggedin']) && $_COOKIE['loggedin'] === "true" ? 1 : 0;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Tổng Quan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-100">
<main class="flex flex-col items-center justify-center h-screen text-center px-6">
    <h2 class="text-2xl font-bold mb-6">Tổng Quan</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 w-full max-w-4xl mx-auto">
        <div class="bg-white shadow-md px-6 py-10 rounded-lg text-center min-h-32">
            <p class="text-lg font-bold text-gray-700">Số Sản Phẩm</p>
            <p class="text-3xl font-black text-blue-700"><?= $products_count ?></p>
        </div>
        <div class="bg-white shadow-md px-6 py-10 rounded-lg text-center min-h-32">
            <p class="text-lg font-bold text-gray-700">Người Dùng</p>
            <p class="text-3xl font-black text-blue-700"><?= $logged_in_count ?></p>
        </div>
        <div class="bg-white shadow-md px-6 py-10 rounded-lg text-center min-h-32">
            <p class="text-lg font-bold text-gray-700">Đơn Hàng</p>
            <p class="text-3xl font-black text-blue-700">null</p>
        </div>
    </div>

    <button class="mt-6 bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700"><a href="products/index.php">Quản lý sản phẩm</a></button>
</main>
</body>
<?php
    include 'includes/footer.php';
?>
</body>
</html>
