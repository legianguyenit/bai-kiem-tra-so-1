<?php
    session_start();
    if (!isset($_COOKIE['loggedin'])) {
        header("Location: login.php");
        exit();
    }
    include 'config/database.php';
    include 'includes/header.php';
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

    <!-- Sản phẩm -->
    <a href="http://localhost/orders/index.php" class="block">
        <div class="bg-white shadow-md px-6 py-10 rounded-lg text-center min-h-32 hover:shadow-xl transition">
            <p class="text-lg font-bold text-gray-700">Tổng doanh thu</p>
            <p class="text-3xl font-black text-blue-700" id="total-revenue">0</p>
        </div>
    </a>

    <!-- Người dùng -->
    <a href="http://localhost/users/index.php" class="block">
        <div class="bg-white shadow-md px-6 py-10 rounded-lg text-center min-h-32 hover:shadow-xl transition">
            <p class="text-lg font-bold text-gray-700">Người dùng</p>
            <p class="text-3xl font-black text-blue-700" id="total-users">0</p>
        </div>
    </a>

    <!-- Danh mục -->
    <a href="http://localhost/categories/index.php" class="block">
        <div class="bg-white shadow-md px-6 py-10 rounded-lg text-center min-h-32 hover:shadow-xl transition">
            <p class="text-lg font-bold text-gray-700">Danh mục</p>
            <p class="text-3xl font-black text-blue-700" id="total-categories">0</p>
        </div>
    </a>

    <!-- Đơn hàng -->
    <a href="http://localhost/orders/index.php" class="block">
        <div class="bg-white shadow-md px-6 py-10 rounded-lg text-center min-h-32 hover:shadow-xl transition">
            <p class="text-lg font-bold text-gray-700">Đơn hàng</p>
            <p class="text-3xl font-black text-blue-700" id="total-orders">0</p>
        </div>
    </a>

    <!-- Đơn hàng chờ -->
    <a href="http://localhost/orders/index.php" class="block">
        <div class="bg-white shadow-md px-6 py-10 rounded-lg text-center min-h-32 hover:shadow-xl transition">
            <p class="text-lg font-bold text-gray-700">Đơn hàng chờ</p>
            <p class="text-3xl font-black text-blue-700" id="total-cho-xac-nhan">0</p>
        </div>
    </a>

    <!-- Đã nhận hàng -->
    <a href="http://localhost/orders/index.php" class="block">
        <div class="bg-white shadow-md px-6 py-10 rounded-lg text-center min-h-32 hover:shadow-xl transition">
            <p class="text-lg font-bold text-gray-700">Đã nhận hàng</p>
            <p class="text-3xl font-black text-blue-700" id="total-da-nhan-hang">0</p>
        </div>
    </a>
    </div>
    </div>
    <button class="mt-6 bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
        <a href="products/index.php">Quản lý sản phẩm</a>
    </button>
</main>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $.ajax({
            url: 'api/v1/categories/getTotalCategories.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#total-categories').text(data.total_categories);
            },
            error: function () {
                console.error("Lỗi khi tải dữ liệu thống kê.");
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $.ajax({
            url: 'api/v1/products/getTotalProducts.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#total-products').text(data.total_products);
            },
            error: function () {
                console.error("Lỗi khi tải dữ liệu thống kê.");
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $.ajax({
            url: 'api/v1/users/getTotalUsers.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#total-users').text(data.total_users);
            },
            error: function () {
                console.error("Lỗi khi tải dữ liệu thống kê.");
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $.ajax({
            url: 'api/v1/orders/getTotalOrders.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#total-orders').text(data.total_orders);
            },
            error: function () {
                console.error("Lỗi khi tải dữ liệu thống kê.");
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $.ajax({
            url: 'api/v1/orders/getTotalStatusOrders.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#total-cho-xac-nhan').text(data.total_cho_xac_nhan);
                $('#total-da-nhan-hang').text(data.total_da_nhan_hang);
            },
            error: function () {
                console.error("Lỗi khi tải dữ liệu thống kê.");
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $.ajax({
            url: 'api/v1/orders/getTotalRevenueOrders.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                const formattedRevenue = new Intl.NumberFormat('vi-VN').format(data.total_revenue) + 'đ';
                $('#total-revenue').text(formattedRevenue);
            },
            error: function () {
                console.error("Lỗi khi tải dữ liệu thống kê.");
            }
        });
    });
</script>
</body>
<?php 
    include 'includes/footer.php'; 
?>
</html>
