<?php
    session_start();
    include '../includes/header.php';
    include '../config/database.php';
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
    $successMessage = '';
    if (isset($_SESSION['success_message'])) {
        $successMessage = $_SESSION['success_message'];
        unset($_SESSION['success_message']);
    }
    $error_message = '';
    if (isset($_SESSION['error_message'])) {
        $error_message = $_SESSION['error_message'];
        unset($_SESSION['error_message']);
    }
?>

<body class="bg-blue-100">
    <main class="flex flex-col items-center justify-center min-h-screen text-center px-4 py-8">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-5xl overflow-x-auto">
        <h2 class="text-2xl font-bold mb-6">Danh Sách Người Dùng</h2>
        <?php if (!empty($successMessage)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
                <span class="block sm:inline"><?php echo htmlspecialchars($successMessage); ?></span>
            </div>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
                <span class="block sm:inline"><?php echo htmlspecialchars($error_message); ?></span>
            </div>
        <?php endif; ?>
        <table class="w-full border-collapse text-sm md:text-base">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3 border text-left font-semibold">ID</th>
                    <th class="p-3 border text-left font-semibold">Họ và tên</th>
                    <th class="p-3 border text-left font-semibold">Email</th>
                    <th class="p-3 border text-left font-semibold">Password</th>
                    <th class="p-3 border text-left font-semibold">Thời gian</th>
                    <th class="p-3 border text-left font-semibold">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM users");
                while ($row = $result->fetch_assoc()):
                ?>
                <tr class="border-b">
                    <td class="p-3 border"><?= $row["id"] ?></td>
                    <td class="p-3 border"><?= htmlspecialchars($row["fullname"]) ?></td>
                    <td class="p-3 border"><?= htmlspecialchars($row["email"]) ?></td>
                    <td class="p-3 border max-w-xs overflow-x-auto">
                        <div class="flex items-center gap-2">
                            <span class="password hidden break-all"><?= htmlspecialchars($row["password"]) ?></span>
                            <button class="toggle-password text-blue-600 hover:text-blue-800">
                                👁
                            </button>
                        </div>
                    </td>
                    <td class="p-3 border"><?= $row["created_at"] ?></td>
                    <td class="p-3 border">
                        <div class="flex flex-wrap gap-2 justify-center">
                            <a href="update.php?id=<?= $row["id"] ?>" class="bg-blue-600 text-white px-4 py-1 rounded">Sửa</a>
                            <a href="delete.php?id=<?= $row["id"] ?>" onclick="return confirm('Xoá người dùng này?')" class="bg-red-600 text-white px-4 py-1 rounded">Xóa</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="mt-6 text-center">
            <a href="create.php" class="inline-block bg-blue-600 text-white px-6 py-2 rounded">Thêm người dùng</a>
        </div>
    </div>
    </main>
</body>
<script>
    document.querySelectorAll(".toggle-password").forEach(function(btn) {
        btn.addEventListener("click", function() {
            const passwordSpan = this.previousElementSibling;
            passwordSpan.classList.toggle("hidden");
        });
    });
</script>
<?php
    include '../includes/footer.php';
?>
</body>
</html>
