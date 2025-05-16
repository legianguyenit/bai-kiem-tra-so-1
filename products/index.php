<?php
    // Kiểm tra đăng nhập
    if (!isset($_COOKIE['loggedin'])) {
        header("location: ../login.php");
        exit();
    }

    session_start();
    include '../includes/header.php';
    include '../config/database.php';

    // Lấy thông báo thành công hoặc lỗi
    $success_message = '';
    if (isset($_SESSION['success_message'])) {
        $success_message = $_SESSION['success_message'];
        unset($_SESSION['success_message']);
    }

    $error_message = '';
    if (isset($_SESSION['error_message'])) {
        $error_message = $_SESSION['error_message'];
        unset($_SESSION['error_message']);
    }
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị sản phẩm</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-100">
    <main class="flex flex-col items-center justify-center min-h-screen text-center px-4 py-8">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-5xl overflow-x-auto">
        <h2 class="text-2xl font-bold mb-6">Danh sách sản phẩm</h2>
         <?php
                if (!empty($success_message)) {
                    echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">';
                    echo '<span class="block sm:inline">' . htmlspecialchars($success_message) . '</span>';
                    echo '</div>';
                }
                

                if (!empty($error_message)) {
                    echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">';
                    echo '<span class="block sm:inline">' . htmlspecialchars($error_message) . '</span>';
                    echo '</div>';
                    unset($_SESSION['error_message']);
                }
            ?>
        <table class="w-full border-collapse text-sm md:text-base">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3 border text-left font-semibold">Mã sản phẩm</th>
                    <th class="p-3 border text-left font-semibold">Hình ảnh</th>
                    <th class="p-3 border text-left font-semibold">Tên sản phẩm</th>
                    <th class="p-3 border text-left font-semibold">Giá</th>
                    <th class="p-3 border text-left font-semibold">Mô tả</th>
                    <th class="p-3 border text-left font-semibold">Danh mục</th>
                    <th class="p-3 border text-left font-semibold">Ngày tạo</th>
                    <th class="p-3 border text-left font-semibold">Ngày cập nhật</th>
                    <th class="p-3 border text-left font-semibold">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $result = $conn->query("SELECT * FROM products");
                    while ($row = $result->fetch_assoc()) {
                        // Xác định hình ảnh sản phẩm
                        $image = $row['image'] ? $row['image'] : 'default-product.png';
                        echo '<tr class="border-b">';
                        echo '<td class="p-3 border">' . htmlspecialchars($row['id']) . '</td>';
                        echo '<td class="p-3 border">';
                        echo '<img src="../assets/images/products/' . htmlspecialchars($image) . '" alt="' . htmlspecialchars($row['name']) . '" class="w-16 h-16 object-cover rounded">';
                        echo '</td>';
                        echo '<td class="p-3 border">' . htmlspecialchars($row['name']) . '</td>';
                        echo '<td class="p-3 border">' . number_format($row['price'], 0, ',', '.') . '₫</td>';
                        echo '<td class="p-3 border max-w-xs truncate">' . htmlspecialchars($row['description']) . '</td>';
                        echo '<td class="p-3 border">' . htmlspecialchars($row['category']) . '</td>';
                        echo '<td class="p-3 border">' . htmlspecialchars($row['created_at']) . '</td>';
                        echo '<td class="p-3 border">' . htmlspecialchars($row['updated_at']) . '</td>';
                        echo '<td class="p-3 border">';
                        echo '<div class="flex flex-wrap gap-2 justify-center">';
                        echo '<a href="update.php?id=' . $row['id'] . '" class="bg-blue-600 text-white px-4 py-1 rounded">Sửa</a>';
                        echo '<a href="delete.php?id=' . $row['id'] . '" onclick="return confirm(\'Bạn có chắc muốn xoá sản phẩm này?\')" class="bg-red-600 text-white px-4 py-1 rounded">Xóa</a>';
                        echo '</div>';
                        echo '</td>';
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>

        <div class="mt-6 text-center">
            <a href="create.php" class="inline-block bg-blue-600 text-white px-6 py-2 rounded">Thêm sản phẩm</a>
        </div>
    </div>
    </main>

    <script>
        // Không có mã JavaScript bổ sung ở đây
    </script>

<?php include '../includes/footer.php'; ?>
