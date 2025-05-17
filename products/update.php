<?php
// Bảo mật: chỉ cho người đã login
if (!isset($_COOKIE['loggedin'])) {
    header("Location: ../login.php");
    exit();
}
session_start();
include '../config/database.php';

// Lấy ID sản phẩm từ query string
if (!isset($_GET['product_code'])) {
    header("Location: index.php");
    exit();
}
$product_code = $_GET['product_code'];

// Lấy thông tin sản phẩm cũ
$sql = "SELECT * FROM products WHERE product_code = '$product_code'";
$result = $conn->query($sql);
$product_data = $result->fetch_assoc();
if (empty($product_data)) {
    $_SESSION['error_message'] = "Sản phẩm không tồn tại!";
    header("Location: index.php");
    exit();
}
$old_image = $product_data['product_image'];

// Lấy danh sách categories để dropdown
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

// Khởi tạo biến và errors
$errors = [];
$product_code = $product_data['product_code'];
$product_name = $product_data['product_name'];
$product_price = $product_data['product_price'];
$product_description = $product_data['product_description'];
$categories_code = $product_data['categories_code'];
$product_image = ""; // sẽ chứa tên file mới nếu upload

// Xử lý form POST
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Lấy giá trị từ form
    $product_code       = htmlspecialchars($_POST['product_code']);
    $product_name       = htmlspecialchars($_POST['product_name']);
    $product_price      = htmlspecialchars($_POST['product_price']);
    $product_description= htmlspecialchars($_POST['product_description']);
    $categories_code    = htmlspecialchars($_POST['categories_code']);

    // Validate
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

    // Xử lý upload ảnh mới
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $targetDir = "../assets/images/products/";
        $imageName = time() . "_" . basename($_FILES["product_image"]["name"]);
        $targetFile = $targetDir . $imageName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg','jpeg','png','gif'];

        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFile)) {
                $product_image = $imageName;
            } else {
                $errors['product_image'] = "Lỗi khi tải lên ảnh.";
            }
        } else {
            $errors['product_image'] = "Chỉ hỗ trợ JPG, JPEG, PNG, GIF.";
        }
    }

    // Nếu không upload, giữ ảnh cũ
    if (empty($product_image)) {
        $product_image = $old_image;
    }

    // Nếu không có lỗi thì UPDATE
    if (empty($errors)) {
        $sql = "UPDATE products SET
                    product_code       = '$product_code',
                    product_name       = '$product_name',
                    product_image      = '$product_image',
                    product_price      = '$product_price',
                    product_description= '$product_description',
                    categories_code    = '$categories_code'
                WHERE product_code = '$product_code'";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success_message'] = "Cập nhật sản phẩm thành công!";
            header("Location: index.php");
            exit();
        } else {
            echo "🔴 Lỗi khi cập nhật: " . $conn->error;
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
    <title>Cập nhật sản phẩm</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-100">
    <main class="flex flex-col items-center justify-start min-h-screen text-center px-6 mt-20">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6">Cập nhật sản phẩm</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <!-- Tên sản phẩm -->
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Tên sản phẩm</label>
                    <input type="text" name="product_name" placeholder="Nhập tên sản phẩm"
                        value="<?php echo $product_name ?>" 
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['product_name'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['product_name'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <!-- Mã sản phẩm -->
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Mã sản phẩm</label>
                    <input type="text" name="product_code" placeholder="Nhập mã sản phẩm"
                        value="<?php echo $product_code ?>" 
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['product_code'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['product_code'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <!-- Giá sản phẩm -->
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Giá sản phẩm</label>
                    <input type="text" name="product_price" placeholder="Nhập giá sản phẩm"
                        value="<?php echo $product_price ?>" 
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['product_price'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['product_price'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <!-- Mô tả sản phẩm -->
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Mô tả sản phẩm</label>
                    <input type="text" name="product_description" placeholder="Nhập mô tả sản phẩm"
                        value="<?php echo $product_description ?>" 
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['product_description'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['product_description'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <!-- Danh mục sản phẩm -->
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
                <!-- Ảnh sản phẩm -->
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Hình ảnh sản phẩm (hiện tại: <?php echo htmlspecialchars($old_image); ?>)</label>
                    <input type="file" name="product_image"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['product_image'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['product_image'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">
                    Cập nhật sản phẩm
                </button>
            </form>
        </div>
    </main>
<?php include '../includes/footer.php'; ?>
</body>
</html>
