<?php
include 'config/database.php';

$sql    = "SELECT product_name, product_image, product_price FROM products";
$result = mysqli_query($conn, $sql);

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
<body class="bg-blue-100">
    <main class="flex flex-col items-center justify-start min-h-screen py-10 px-4">
        <div class="bg-white w-full max-w-7xl rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-8 text-center text-gray-800">Sản phẩm nổi bật</h2>

            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <div class="flex flex-wrap -mx-2 justify-center">
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <div class="w-full sm:w-1/2 lg:w-1/4 p-2">
                            <form method="post" action="add_to_cart.php">
                                <input type="hidden" name="product_name" value="<?= htmlspecialchars($row['product_name']); ?>">
                                <input type="hidden" name="product_image" value="<?= htmlspecialchars($row['product_image']); ?>">
                                <input type="hidden" name="product_price" value="<?= $row['product_price']; ?>">

                                <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                                    <img
                                        src="assets/images/products/<?= htmlspecialchars($row['product_image']); ?>"
                                        alt="<?= htmlspecialchars($row['product_name']); ?>"
                                        class="w-full h-auto object-contain"
                                    >
                                    <div class="p-4 text-center">
                                        <h3 class="text-base font-semibold text-gray-700">
                                            <?= htmlspecialchars($row['product_name']); ?>
                                        </h3>
                                        <p class="text-lg font-bold text-gray-900 mt-1">
                                            <?= number_format($row['product_price'], 0, ',', '.') . 'đ'; ?>
                                        </p>
                                        <button type="submit"
                                            class="mt-3 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                            Thêm vào giỏ
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p class="text-center text-gray-500">Chưa có sản phẩm nào.</p>
            <?php endif; ?>

            <?php
                if ($result) mysqli_free_result($result);
                mysqli_close($conn);
            ?>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
