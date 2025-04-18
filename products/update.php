<?php
    include '../includes/header.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập Nhật Sản Phẩm</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<?php
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    
    if (isset($_COOKIE['products'])) {
        $products = json_decode($_COOKIE['products'], true);
        
        $product = null;
        foreach ($products as $p) {
            if ($p['product_id'] == $product_id) {
                $product = $p;
                break;
            }
        }

        if (!$product) {
            header('Location: product_list.php');
            exit;
        }
    }
} else {
    header('Location: product_list.php');
    exit;
}

$errors = [];
$product_name = $product_price = $product_description = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $product_name = htmlspecialchars($_POST['product_name']);
    $product_price = htmlspecialchars($_POST['product_price']);
    $product_description = htmlspecialchars($_POST['product_description']);

    if (empty($product_name)) {
        $errors['product_name'] = "Vui lòng nhập tên sản phẩm.";
    } elseif ((strlen($product_name) < 6)) {
        $errors['product_name'] = "Tên sản phẩm phải ít nhất 6 ký tự.";
    }

    if (empty($product_price)) {
        $errors['product_price'] = "Vui lòng nhập giá sản phẩm.";
    }

    if (empty($product_description)) {
        $errors['product_description'] = "Vui lòng nhập mô tả sản phẩm.";
    } elseif ((strlen($product_description) < 6)) {
        $errors['product_description'] = "Mô tả sản phẩm phải ít nhất 6 ký tự.";
    }

    if (empty($errors)) {
        $sent_success = "$product_name đã cập nhật sản phẩm. Trân trọng.";

        foreach ($products as &$update_product) {
            if ($update_product['product_id'] == $product_id) {
                $update_product['product_name'] = $product_name;
                $update_product['product_price'] = $product_price;
                $update_product['product_description'] = $product_description;
                break;
            }
        }

        setcookie("products", json_encode($products), time() + (86400 * 30), "/");
        $product_name = $product_price = $product_description = "";
    }
}
?>
<body class="bg-blue-100"> 
    <main class="flex flex-col items-center justify-start min-h-screen text-center px-6 mt-20">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6">Cập Nhật Sản Phẩm</h2>
            <?php
            if (!empty($sent_success)) {
                echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md">
                        <p>' . htmlspecialchars($sent_success) . '</p>
                    </div>';
            }
            ?>  
            <form action="update.php?id=<?php echo $product_id; ?>" method="POST">
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Tên Sản Phẩm</label>
                    <input type="text" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['product_name'])) {
                            echo "<div style='color: red;'>" . $errors['product_name'] . "</div>";
                        }
                    ?>
                </div>
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Giá (VND)</label>
                    <input type="number" name="product_price" value="<?php echo htmlspecialchars($product['product_price']); ?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['product_price'])) {
                            echo "<div style='color: red;'>" . $errors['product_price'] . "</div>";
                        }
                    ?>
                </div>
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Mô Tả</label>
                    <textarea name="product_description" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 h-32"><?php echo htmlspecialchars($product['product_description']); ?></textarea>
                    <?php
                        if (isset($errors['product_description'])) {
                            echo "<div class='text-red-500 text-sm mt-1'>" . $errors['product_description'] . "</div>";
                        }
                    ?>
                </div>
                <button class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">Cập Nhật Sản Phẩm</button>
            </form>
        </div>  
    </main>
</body>
</html>
<?php
include '../includes/footer.php';
?>
