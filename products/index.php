<?php
    include '../includes/header.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Tổng Quan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<?php
    if (!isset($_COOKIE['loggedin'])) {
        header("location: ../login.php");
        exit();
    }
?>

<body class="bg-blue-100">
    <main class="flex flex-col items-center justify-center h-screen text-center px-6">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-3xl">
    <h2 class="text-2xl font-bold mb-6">Danh Sách Sản Phẩm</h2>
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3 border text-left font-semibold">ID</th>
                    <th class="p-3 border text-left font-semibold">Tên Sản Phẩm</th>
                    <th class="p-3 border text-left font-semibold">Mô Tả Sản Phẩm</th>
                    <th class="p-3 border text-left font-semibold">Giá</th>
                    <th class="p-3 border text-left font-semibold">Hành Động</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if (!empty($_COOKIE['products'])) {
                    $products = json_decode($_COOKIE['products'], true);

                    foreach ($products as $product) {
                        echo "<tr class='border-b'>
                                <td class='p-3 border'>{$product['product_id']}</td>
                                <td class='p-3 border'>{$product['product_name']}</td>
                                <td class='p-3 border'>{$product['product_description']}</td>
                                <td class='p-3 border'>{$product['product_price']} VNĐ</td>
                                <td class='p-3 border flex space-x-2'>
                                    <a href='update.php?id={$product['product_id']}'>
                                        <button class='bg-blue-600 text-white px-4 py-1 rounded'>Sửa</button>
                                    </a>
                                    <a href='delete.php?id={$product['product_id']}'>
                                        <button class='bg-red-600 text-white px-4 py-1 rounded'>Xóa</button>
                                    </a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='p-3 border text-center'>Không có sản phẩm</td></tr>";
                    }
                ?>
            </tbody>
        </table>
        <div class="mt-4 text-center">
            <button class="bg-blue-600 text-white px-6 py-2 rounded"><a href="create.php">Thêm Sản Phẩm</a></button>
        </div>
    </div>
    </main>
</body>
<?php
    include '../includes/footer.php';
?>
</body>
</html>
