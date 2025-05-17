<?php
session_start();
if (!isset($_COOKIE['loggedin'])) {
    header("Location: login.php");
    exit();
}

include 'config/database.php';
include 'includes/header.php';

// Lấy user ID từ session hoặc cookie
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    echo "Không tìm thấy người dùng.";
    exit();
}

$sql = "SELECT fullname,role, email, avatar, created_at, updated_at FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Không tìm thấy hồ sơ người dùng.";
    exit();
}

$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hồ Sơ Người Dùng</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <main class="max-w-xl mx-auto mt-20 bg-white p-8 rounded shadow text-center">
        <h2 class="text-2xl font-bold mb-6 text-blue-700">Hồ sơ nhân sự</h2>

        <!-- Avatar -->
        <div class="mb-6">
            <img src="<?= htmlspecialchars(!empty($user['avatar']) ? 'assets/images/avatar/' . $user['avatar'] : 'uploads/default-avatar.png') ?>" 
            alt="Avatar" 
            class="max-w-xs rounded-full mx-auto border-4 border-blue-500 shadow">
        </div>

        <div class="space-y-4 text-left">
            <div>
                <p class="text-gray-600 font-semibold">Vai trò:</p>
                <p class="text-lg"><?= htmlspecialchars($user['role']) ?></p>
            </div>
            <div>
                <p class="text-gray-600 font-semibold">Họ và tên:</p>
                <p class="text-lg"><?= htmlspecialchars($user['fullname']) ?></p>
            </div>
            <div>
                <p class="text-gray-600 font-semibold">Email:</p>
                <p class="text-lg"><?= htmlspecialchars($user['email']) ?></p>
            </div>
            <div>
                <p class="text-gray-600 font-semibold">Ngày tạo:</p>
                <p class="text-lg"><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></p>
            </div>
            <div>
                <p class="text-gray-600 font-semibold">Cập nhật lần cuối:</p>
                <p class="text-lg"><?= date('d/m/Y H:i', strtotime($user['updated_at'])) ?></p>
            </div>
        </div>

        <div class="mt-6">
            <a href="dashboard.php" class="text-blue-600 hover:underline">← Quay lại trang tổng quan</a>
        </div>
    </main>
</body>
<?php include 'includes/footer.php'; ?>
</html>
