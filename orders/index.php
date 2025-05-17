<?php
// kiểm tra đăng nhập
if (!isset($_COOKIE['loggedin'])) {
    header("Location: ../login.php");
    exit();
}

session_start();
include '../includes/header.php';
include '../config/database.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Quản trị đơn hàng</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-100">
  <main class="flex flex-col items-center justify-center min-h-screen px-4 py-8">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-6xl overflow-x-auto">
      <h2 class="text-2xl font-bold mb-6">Danh sách đơn hàng</h2>

      <table class="w-full border-collapse text-sm md:text-base">
        <thead>
          <tr class="bg-gray-100">
            <th class="p-3 border font-semibold">#</th>
            <th class="p-3 border font-semibold">Khách hàng</th>
            <th class="p-3 border font-semibold">Điện thoại</th>
            <th class="p-3 border font-semibold">Email</th>
            <th class="p-3 border font-semibold">Địa chỉ</th>
            <th class="p-3 border font-semibold">PT Thanh toán</th>
            <th class="p-3 border font-semibold">Tổng tiền</th>
            <th class="p-3 border font-semibold">Ngày tạo</th>
            <th class="p-3 border font-semibold">Cập nhật</th>
            <th class="p-3 border font-semibold">Trạng thái</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql    = "SELECT * FROM orders ORDER BY created_at DESC";
          $result = $conn->query($sql);
          $i = 1;
          while ($row = $result->fetch_assoc()):
          ?>
          <tr class="border-b">
            <td class="p-3 border"><?= $i++ ?></td>
            <td class="p-3 border"><?= htmlspecialchars($row['customer_name']) ?></td>
            <td class="p-3 border"><?= htmlspecialchars($row['phone']) ?></td>
            <td class="p-3 border"><?= htmlspecialchars($row['email']) ?></td>
            <td class="p-3 border"><?= htmlspecialchars($row['address']) ?></td>
            <td class="p-3 border"><?= htmlspecialchars($row['payment_method']) ?></td>
            <td class="p-3 border"><?= number_format($row['total_amount'],0,',','.') . 'đ' ?></td>
            <td class="p-3 border"><?= $row['created_at'] ?></td>
            <td class="p-3 border"><?= $row['updated_at'] ?></td>
            <td class="p-3 border">
              <form method="post" action="../api/v1/orders/updateStatusOrder.php" class="flex items-center gap-2">
                <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                <select name="status" class="border rounded px-2 py-1">
                  <option value="cho_xac_nhan"        <?= $row['status']=='cho_xac_nhan'        ? 'selected' : '' ?>>Chờ xác nhận</option>
                  <option value="dang_van_chuyen"     <?= $row['status']=='dang_van_chuyen'     ? 'selected' : '' ?>>Đang vận chuyển</option>
                  <option value="thanh_toan_thanh_cong"<?= $row['status']=='thanh_toan_thanh_cong'? 'selected' : '' ?>>Thanh toán thành công</option>
                  <option value="da_nhan_hang"         <?= $row['status']=='da_nhan_hang'         ? 'selected' : '' ?>>Đã nhận hàng</option>
                </select>
                <button type="submit" 
                        class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition">
                  Cập nhật
                </button>
              </form>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </main>
  <?php include '../includes/footer.php'; ?>
</body>
</html>
