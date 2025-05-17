<?php
session_start();
include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt hàng thành công</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <main class="flex-grow flex items-center justify-center px-4 py-8">
        <div class="max-w-md w-full bg-white p-6 rounded shadow text-center">
            <svg class="mx-auto mb-4 h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h1 class="text-2xl font-bold mb-2">Đặt hàng thành công!</h1>
            <p class="text-gray-700 mb-6">
                Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ liên hệ để xác nhận đơn và giao hàng sớm nhất!
            </p>
            <a href="index.php"
               class="inline-block px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Tiếp tục mua sắm
            </a>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
