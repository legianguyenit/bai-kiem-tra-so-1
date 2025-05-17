<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product = [
        'name'  => $_POST['product_name'],
        'image' => $_POST['product_image'],
        'price' => (int)$_POST['product_price'],
        'quantity' => 1
    ];

    $product_id = md5($product['name']);

    // Nếu đã có trong giỏ, tăng số lượng
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$product_id] = $product;
    }
}

header('Location: cart.php');
exit();
