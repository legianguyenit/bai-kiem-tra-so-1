<?php
    session_start();
    include '../config/database.php';

    $errors = [];
    $categories_name = $categories_description = "";
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $categories_name = htmlspecialchars($_POST['categories_name']);
        $categories_description = htmlspecialchars($_POST['categories_description']);
    
        // Kiểm tra lỗi
        if (empty($categories_name)) {
            $errors['categories_name'] = "Vui lòng nhập tên danh mục.";
        } elseif (strlen($categories_name) < 6) {
            $errors['categories_name'] = "Danh mục phải ít nhất 1 ký tự.";
        }
    
        if (empty($categories_description)) {
            $errors['categories_description'] = "Vui lòng nhập mô tả.";
        } elseif (strlen($categories_description) < 6) {
            $errors['categories_description'] = "Mô tả phải ít nhất 6 ký tự.";
        }

        if (empty($errors)) {
            $sql = "INSERT INTO categories (name, description) VALUES ('$categories_name', '$categories_description')";
            if ($conn->query($sql) === TRUE) {
                $_SESSION['success_message'] = "Thêm danh mục thành công!";
                header("Location: index.php");
                exit();
            } else {
                echo "🔴 Lỗi: " . $conn->error;
            }
        }
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
<?php
    include '../includes/header.php';
?>
<body class="bg-blue-100"> 
    <main class="flex flex-col items-center justify-start min-h-screen text-center px-6 mt-20">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6">Thêm danh mục</h2> 
            <form action="create.php" method="POST" enctype="multipart/form-data">
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Tên danh mục</label>
                    <input type="text" placeholder="Nhập họ tên" name="categories_name" value="<?php echo $categories_name?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['categories_name'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['categories_name'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Mô tả</label>
                    <textarea name="categories_description" placeholder="Nhập nội dung..." class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 h-32"></textarea>
                    <?php
                        if (isset($errors['categories_description'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['categories_description'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <button class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">Thêm người dùng</button>
            </form>
        </div>  
    </main>
<?php
    include '../includes/footer.php';
?>
</body>
</html>