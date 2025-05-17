<?php
session_start();
include 'config/database.php';
include 'includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $phone   = mysqli_real_escape_string($conn, $_POST['phone']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $payment = 'COD';

    if (isset($_COOKIE['loggedin'], $_SESSION['user_id']) && $_COOKIE['loggedin']==='true') {
        $user_id = (int)$_SESSION['user_id'];
        $res = mysqli_query($conn, "SELECT fullname FROM users WHERE id=$user_id LIMIT 1");
        $dispName = $res && $row = mysqli_fetch_assoc($res)
                    ? mysqli_real_escape_string($conn, $row['fullname'])
                    : $name;
    } else {
        $user_id  = null;
        $dispName = "Guest_{$name}";
    }

    // Kiểm tra giỏ hàng
    if (empty($_SESSION['cart'])) {
        $error = 'Giỏ hàng trống.';
    } else {
        // Tính tổng
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Insert vào orders
        $sql1 = sprintf(
            "INSERT INTO orders
             (user_id, customer_name, phone, email, address, payment_method, total_amount, status, created_at)
             VALUES (%s, '%s', '%s', '%s', '%s', '%s', %d, 'cho_xac_nhan', NOW())",
             $user_id!==null ? $user_id : 'NULL',
             $dispName, $phone, $email, $address, $payment, $total
        );

        if (mysqli_query($conn, $sql1)) {
            $order_id = mysqli_insert_id($conn);

            // Insert chi tiết đơn hàng vào order_items
            $items_sql = [];
            foreach ($_SESSION['cart'] as $item) {
                $code   = mysqli_real_escape_string($conn, $item['code'] ?? '');
                $iname  = mysqli_real_escape_string($conn, $item['name']);
                $iprice = (int)$item['price'];
                $iqty   = (int)$item['quantity'];

                $items_sql[] = "($order_id,'$code','$iname',$iprice,$iqty)";
            }

            $sql2 = "INSERT INTO order_items
                     (order_id, product_code, product_name, product_price, quantity)
                     VALUES " . implode(',', $items_sql);

            if (mysqli_query($conn, $sql2)) {
                unset($_SESSION['cart']);
                header("Location: order_success.php");
                exit();
            } else {
                $error = 'Lỗi lưu chi tiết đơn: '. mysqli_error($conn);
            }
        } else {
            $error = 'Lỗi lưu đơn hàng: '. mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt hàng</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
  <main class="flex-grow container mx-auto px-4 py-8">
    <?php if ($error): ?>
      <div class="max-w-lg mx-auto mb-6 p-4 bg-red-100 text-red-700 rounded">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- FORM ĐẶT HÀNG -->
      <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Thông tin đặt hàng</h2>
        <form method="post" class="space-y-4">
          <div>
            <label class="block mb-1">Họ và tên</label>
            <input name="name" required
              value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
              class="w-full border rounded px-3 py-2" />
          </div>
          <div>
            <label class="block mb-1">Số điện thoại</label>
            <input name="phone" type="tel" required
              value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>"
              class="w-full border rounded px-3 py-2" />
          </div>
          <div>
            <label class="block mb-1">Email</label>
            <input name="email" type="email" required
              value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
              class="w-full border rounded px-3 py-2" />
          </div>
          <div>
            <label class="block mb-1">Địa chỉ</label>
            <textarea name="address" required
              class="w-full border rounded px-3 py-2"><?php echo htmlspecialchars($_POST['address'] ?? ''); ?></textarea>
          </div>
          <div>
            <label class="block mb-1">Phương thức thanh toán</label>
            <div class="flex items-center gap-2">
              <input type="radio" id="cod" checked class="form-radio" />
              <label for="cod">Thanh toán khi nhận hàng (COD)</label>
            </div>
          </div>
          <button type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
            Thanh toán
          </button>
        </form>
      </div>

      <!-- TÓM TẮT ĐƠN HÀNG -->
      <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Tóm tắt đơn hàng</h2>
        <?php if (!empty($_SESSION['cart'])): ?>
          <ul class="divide-y">
            <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $it):
              $sub = $it['price'] * $it['quantity'];
              $total += $sub;
            ?>
              <li class="py-3 flex justify-between items-center">
                <div>
                  <p class="font-semibold"><?php echo htmlspecialchars($it['name']); ?></p>
                  <p class="text-sm text-gray-600">
                    SL: <?php echo $it['quantity']; ?>
                  </p>
                </div>
                <p class="font-medium"><?php echo number_format($sub,0,',','.') . 'đ'; ?></p>
              </li>
            <?php endforeach; ?>
            <li class="pt-4 flex justify-between font-bold">
              <span>Tổng cộng:</span>
              <span class="text-red-600"><?php echo number_format($total,0,',','.') . 'đ'; ?></span>
            </li>
          </ul>
        <?php else: ?>
          <p>Giỏ hàng trống.</p>
        <?php endif; ?>
      </div>
    </div>
  </main>

  <?php include 'includes/footer.php'; ?>
</body>
</html>
