<?php
session_start();
if (isset($_GET['remove'])) {
    $idToRemove = $_GET['remove'];
    if (isset($_SESSION['cart'][$idToRemove])) {
        unset($_SESSION['cart'][$idToRemove]);
    }
    header("Location: cart.php");
    exit();
}

include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <main class="flex-grow">
        <div class="max-w-4xl mx-auto p-4 sm:p-6 bg-white shadow mt-6 sm:mt-10 rounded">
            <h1 class="text-xl sm:text-2xl font-bold mb-4 text-center">Giỏ hàng của bạn</h1>

            <?php if (!empty($_SESSION['cart'])): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b bg-gray-200">
                                <th class="p-2 text-left">Sản phẩm</th>
                                <th class="p-2 text-center hidden sm:table-cell">Đơn giá</th>
                                <th class="p-2 text-center hidden sm:table-cell">Xóa</th>
                                <th class="p-2 text-center">Số lượng</th>
                                <th class="p-2 text-center">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            foreach ($_SESSION['cart'] as $id => $item):
                                $subtotal = $item['price'] * $item['quantity'];
                                $total += $subtotal;
                            ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-2 flex items-center gap-3">
                                        <img src="assets/images/products/<?php echo htmlspecialchars($item['image']); ?>"
                                             class="w-14 h-14 object-contain flex-shrink-0"
                                             alt="<?php echo htmlspecialchars($item['name']); ?>">
                                        <span class="text-sm"><?php echo htmlspecialchars($item['name']); ?></span>
                                    </td>
                                    <td class="p-2 text-center hidden sm:table-cell">
                                        <?php echo number_format($item['price'], 0, ',', '.') . 'đ'; ?>
                                    </td>
                                    <td class="p-2 text-center hidden sm:table-cell">
                                        <a href="?remove=<?php echo $id; ?>"
                                           onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')"
                                           class="text-red-500 hover:underline">
                                           Xóa
                                        </a>
                                    </td>
                                    <td class="p-2 text-center"><?php echo $item['quantity']; ?></td>
                                    <td class="p-2 text-center">
                                        <?php echo number_format($subtotal, 0, ',', '.') . 'đ'; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="font-bold bg-gray-100">
                                <td colspan="4" class="p-2 text-right">Tổng cộng:</td>
                                <td class="p-2 text-center text-red-600">
                                    <?php echo number_format($total, 0, ',', '.') . 'đ'; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-right mt-4">
                    <a href="order.php"
                       class="inline-block px-6 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                        Tiếp tục Thanh Toán
                    </a>
                </div>
            <?php else: ?>
                <p class="text-center text-gray-500">Giỏ hàng trống.</p>
            <?php endif; ?>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
