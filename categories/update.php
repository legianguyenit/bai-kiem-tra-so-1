<?php
    if (!isset($_COOKIE['loggedin'])) {
        header("location: ../login.php");
        exit();
    }
?>
<?php
    session_start();
    include '../config/database.php';
?>
<?php
    if (!isset($_GET['categories_code'])) {
        header('location:index.php');
    }

    $categories_code = $_GET['categories_code'];

    $sql = "SELECT * FROM categories WHERE categories_code = '$categories_code'";

    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "Lỗi truy vấn: " . mysqli_error($conn);
        exit();
    }

    $category_data = $result->fetch_assoc();
    if (empty($category_data)) {
        $_SESSION['error_message'] = "Mã danh mục không tồn tại!";
        header("Location:index.php");
        exit();
    }
?>
<?php
    $errors = [];
    $categories_name = $categories_description = "";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $categories_name = htmlspecialchars($_POST['categories_name']);
        $categories_description = htmlspecialchars($_POST['categories_description']);

        if (empty($categories_name)) {
            $errors['categories_name'] = "Vui lòng nhập tên danh mục.";
        }

        if (empty($categories_description)) {
            $errors['categories_description'] = "Vui lòng nhập mô tả.";
        }

        if (empty($errors)) {
            $sql_update = "UPDATE categories SET categories_name = '$categories_name', categories_description = '$categories_description' WHERE categories_code = '$categories_code'";

            if ($conn->query($sql_update) === TRUE) {
                $_SESSION['success_message'] = "Cập nhật danh mục thành công!";
                header("Location: index.php");
                exit();
            } else {
                echo "🔴 Lỗi: " . $conn->error;
            }
        }
    }
?>
<?php
    include '../includes/header.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật danh mục</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-100"> 
    <main class="flex flex-col items-center justify-start min-h-screen text-center px-6 mt-20">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6">Cập nhật danh mục</h2> 
            <form action="" method="POST">
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Tên danh mục</label>
                    <input type="text" placeholder="Nhập tên danh mục" name="categories_name" value="<?php echo htmlspecialchars($category_data["categories_name"]); ?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['name'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['name'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Mô tả</label>
                    <textarea placeholder="Nhập mô tả" name="categories_description" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo htmlspecialchars($category_data["categories_description"]); ?></textarea>
                    <?php
                        if (isset($errors['description'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['description'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <button class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">Cập nhật</button>
            </form>
        </div>  
    </main>
<?php
    include '../includes/footer.php';
?>
</body>
</html>
