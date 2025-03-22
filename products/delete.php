<?php
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    if (isset($_COOKIE['products'])) {
        $products = json_decode($_COOKIE['products'], true);

        $products = array_filter($products, function($product) use ($product_id) {
            return $product['product_id'] != $product_id;
        });

        setcookie("products", json_encode(array_values($products)), time() + (86400 * 30), "/");

        header('Location: index.php');
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}
?>
