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
$errors = [];
$product_code = $product_name = $product_price = $product_description = $categories_code = "";

// Lấy danh sách categories
$categories = [];
$sqlCat = "SELECT categories_code, categories_name FROM categories";
if ($resCat = $conn->query($sqlCat)) {
    while ($row = $resCat->fetch_assoc()) {
        $categories[] = $row;
    }
    $resCat->free();
} else {
    echo "🔴 Lỗi khi lấy danh mục: " . $conn->error;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $product_code = htmlspecialchars($_POST['product_code']);
    $product_name = htmlspecialchars($_POST['product_name']);
    $product_price = htmlspecialchars($_POST['product_price']);
    $product_description = htmlspecialchars($_POST['product_description']);
    $categories_code = htmlspecialchars($_POST['categories_code']);

    // Kiểm tra lỗi
    if (empty($product_code)) {
        $errors['product_code'] = "Vui lòng nhập mã sản phẩm.";
    }

    if (empty($product_name)) {
        $errors['product_name'] = "Vui lòng nhập tên sản phẩm.";
    }

    if (empty($product_price)) {
        $errors['product_price'] = "Vui lòng nhập giá sản phẩm.";
    }

    if (empty($product_description)) {
        $errors['product_description'] = "Vui lòng nhập mô tả.";
    }

    if (empty($categories_code)) {
        $errors['categories_code'] = "Vui lòng chọn danh mục sản phẩm.";
    }

    $product_image = "";
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $targetDir = "../assets/images/products/";
        $product_image_Name = time() . "_" . basename($_FILES["product_image"]["name"]);
        $targetFile = $targetDir . $product_image_Name;

        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFile)) {
                $product_image = $product_image_Name;
            } else {
                $errors['product_image'] = "Lỗi khi tải lên ảnh.";
            }
        } else {
            $errors['product_image'] = "Chỉ hỗ trợ các định dạng ảnh JPG, JPEG, PNG, GIF, WEBP.";
        }
    }

    if (empty($product_image)) {
        $errors['product_image'] = "Vui lòng không để trống hình sản phẩm.";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO products (product_code, product_name, product_image, product_price, product_description, categories_code)
                VALUES ('$product_code', '$product_name', '$product_image', '$product_price', '$product_description', '$categories_code')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success_message'] = "Thêm sản phẩm thành công!";
            header("Location: index.php");
            exit();
        } else {
            echo "🔴 Lỗi khi thêm sản phẩm: " . $conn->error;
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
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-100"> 
    <main class="flex flex-col items-center justify-start min-h-screen text-center px-6 mt-20">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6">Thêm sản phẩm</h2> 
            <form action="create.php" method="POST" enctype="multipart/form-data">
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Tên sản phẩm</label>
                    <input type="text" placeholder="Nhập tên sản phẩm" name="product_name" value="<?php echo $product_name?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['product_name'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['product_name'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Mã sản phẩm</label>
                    <input type="text" placeholder="Nhập mã sản phẩm" name="product_code" value="<?php echo $product_code	?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['product_code'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['product_code'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Giá sản phẩm</label>
                    <input type="text" placeholder="Nhập giá sản phẩm" name="product_price" value="<?php echo $product_price?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['product_price'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['product_price'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Mô tả sản phẩm</label>
                    <input type="text" placeholder="Nhập mô tả sản phẩm" name="product_description" value="<?php echo $product_description?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['product_description'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['product_description'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Danh mục sản phẩm</label>
                    <select name="categories_code"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Chọn danh mục --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['categories_code']; ?>"
                                <?php if ($categories_code === $cat['categories_code']) echo 'selected'; ?>>
                                <?php echo $cat['categories_name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php
                        if (isset($errors['categories_code'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['categories_code'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Hình ảnh sản phẩm</label>
                    <input type="file" name="product_image" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['product_image'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['product_image'];
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