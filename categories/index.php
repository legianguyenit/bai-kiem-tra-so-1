<?php
    if (!isset($_COOKIE['loggedin'])) {
        header("location: ../login.php");
        exit();
    }
?>
<?php
    session_start();
    include '../includes/header.php';
    include '../config/database.php';
?>
<?php
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
    <title>Quản trị danh mục</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-100">
    <main class="flex flex-col items-center justify-center min-h-screen text-center px-4 py-8">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-5xl overflow-x-auto">
        <h2 class="text-2xl font-bold mb-6">Danh sách danh mục</h2>
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
                    <th class="p-3 border text-left font-semibold">Mã danh mục</th>
                    <th class="p-3 border text-left font-semibold">Tên danh mục</th>
                    <th class="p-3 border text-left font-semibold">Mô tả</th>
                    <th class="p-3 border text-left font-semibold">Ngày tạo</th>
                    <th class="p-3 border text-left font-semibold">Ngày cập nhật</th>
                    <th class="p-3 border text-left font-semibold">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $result = $conn->query("SELECT * FROM categories");
                    while ($row = $result->fetch_assoc()) {
                        echo '
                            <tr class="border-b">
                                <td class="p-3 border">' . $row["categories_code"] . '</td>
                                <td class="p-3 border">' . htmlspecialchars($row["categories_name"]) . '</td>
                                <td class="p-3 border">' . htmlspecialchars($row["categories_description"]) . '</td>
                                <td class="p-3 border">' . $row["created_at"] . '</td>
                                <td class="p-3 border">' . $row["updated_at"] . '</td>
                                <td class="p-3 border">
                                    <div class="flex flex-wrap gap-2 justify-center">
                                        <a href="update.php?categories_code=' . $row["categories_code"] . '" class="bg-blue-600 text-white px-4 py-1 rounded">Sửa</a>
                                        <a href="delete.php?categories_code=' . $row["categories_code"] . '" onclick="return confirm(\'Xoá danh mục này?\')" class="bg-red-600 text-white px-4 py-1 rounded">Xóa</a>
                                    </div>
                                </td>
                            </tr>
                            ';
                        }
                    ?>
            </tbody>
        </table>
        <div class="mt-6 text-center">
            <a href="create.php" class="inline-block bg-blue-600 text-white px-6 py-2 rounded">Thêm danh mục</a>
        </div>
    </div>
    </main>
</body>
<?php
    include '../includes/footer.php';
?>
</body>
</html>
