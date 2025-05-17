<header class="bg-white shadow-md p-3">
  <div class="container mx-auto px-4 md:px-8">
    <!-- Mobile: hamburger - logo center -->
    <div class="flex md:hidden items-center justify-between w-full">
      <button class="text-gray-700 focus:outline-none text-lg" onclick="toggleMobileMenu()">☰</button>
      <h1 class="text-lg font-bold">
        <img src="../assets/images/logo/thecao5s.png" alt="Logo" class="h-10 w-auto">
      </h1>
      <div class="w-6"></div>
    </div>

    <!-- Desktop -->
    <div class="hidden md:flex justify-between items-center">
      <h1 class="text-lg font-bold">
        <img src="../assets/images/logo/thecao5s.png" alt="Logo" class="h-10 w-auto">
      </h1>
      <nav>
        <ul id="desktop-menu" class="flex flex-row space-x-1">
  <?php if (!isset($_COOKIE['role']) || $_COOKIE['role'] === 'customer'): ?>
      <li><a href="../index.php" class="block py-2 px-3 text-gray-700 hover:text-blue-500">Trang chủ</a></li>
  <?php elseif (in_array($_COOKIE['role'], ['admin', 'seller'])): ?>
      <li><a href="../dashboard.php" class="block py-2 px-3 text-gray-700 hover:text-blue-500">Dashboard</a></li>
  <?php endif; ?>

  <?php if (isset($_COOKIE['role']) && in_array($_COOKIE['role'], ['admin', 'seller'])): ?>
    <li><a href="../products/index.php" class="block py-2 px-3 text-gray-700 hover:text-blue-500">Sản phẩm</a></li>
    <li><a href="../categories/index.php" class="block py-2 px-3 text-gray-700 hover:text-blue-500">Danh mục</a></li>
  <?php endif; ?>

  <?php if (isset($_COOKIE['role']) && $_COOKIE['role'] === 'admin'): ?>
    <li><a href="../orders/index.php" class="block py-2 px-3 text-gray-700 hover:text-blue-500">Đơn hàng</a></li>
    <li><a href="../users/index.php" class="block py-2 px-3 text-gray-700 hover:text-blue-500">Người dùng</a></li>
  <?php endif; ?>

  <li><a href="../cart.php" class="block py-2 px-3 text-gray-700 hover:text-blue-500">Giỏ hàng</a></li>

  <li>
    <?php if (isset($_COOKIE['loggedin'], $_COOKIE['fullname']) && $_COOKIE['loggedin'] === 'true'): ?>
      <a href="../profile.php" class="block py-2 px-3 text-gray-700 hover:text-blue-500">
        Hello <?php echo htmlspecialchars($_COOKIE['fullname']); ?>
      </a>
    <?php else: ?>
      <a href="../login.php" class="block py-2 px-3 text-gray-700 hover:text-blue-500">Đăng nhập</a>
    <?php endif; ?>
  </li>

  <li><a href="../contact.php" class="block py-2 px-3 text-gray-700 hover:text-blue-500">Liên hệ</a></li>

  <?php if (isset($_COOKIE['loggedin']) && $_COOKIE['loggedin'] === 'true'): ?>
    <li><a href="../logout.php" class="block py-2 px-3 text-gray-700 hover:text-blue-500">Đăng xuất</a></li>
  <?php endif; ?>
</ul>

      </nav>
    </div>
  </div>

  <!-- Mobile menu -->
  <div id="mobile-menu-container"
       class="fixed left-0 top-0 h-full w-0 bg-white shadow-lg overflow-x-hidden transition-all duration-300 z-50">
    <div class="pt-16 px-4">
      <button onclick="toggleMobileMenu()"
              class="absolute top-4 right-4 text-gray-700 focus:outline-none text-2xl">&times;</button>
      <ul id="mobile-menu" class="flex flex-col w-full space-y-1">
  <li><a href="../index.php" class="block py-2 px-3 text-gray-700 hover:text-blue-500 border-b">Trang chủ</a></li>

  <?php if (isset($_COOKIE['role']) && in_array($_COOKIE['role'], ['admin', 'seller'])): ?>
    <li><a href="../products/index.php" class="block py-2 px-3 text-gray-700 hover:text-blue-500 border-b">Sản phẩm</a></li>
    <li><a href="../categories/index.php" class="block py-2 px-3 text-gray-700 hover:text-blue-500 border-b">Danh mục</a></li>
  <?php endif; ?>

  <?php if (isset($_COOKIE['role']) && $_COOKIE['role'] === 'admin'): ?>
    <li><a href="../orders/index.php" class="block py-2 px-3 text-gray-700 hover:text-blue-500 border-b">Đơn hàng</a></li>
    <li><a href="../users/index.php" class="block py-2 px-3 text-gray-700 hover:text-blue-500 border-b">Người dùng</a></li>
  <?php endif; ?>

  <li><a href="../cart.php" class="block py-2 px-3 text-gray-700 hover:text-blue-500 border-b">Giỏ hàng</a></li>

  <li>
    <?php if (isset($_COOKIE['loggedin'], $_COOKIE['fullname']) && $_COOKIE['loggedin'] === 'true'): ?>
      <a href="../profile.php" class="block py-2 px-3 text-gray-700 hover:text-blue-500 border-b">
        Hello <?php echo htmlspecialchars($_COOKIE['fullname']); ?>
      </a>
    <?php else: ?>
      <a href="../login.php" class="block py-2 px-3 text-gray-700 hover:text-blue-500 border-b">Đăng nhập</a>
    <?php endif; ?>
  </li>

  <li><a href="../contact.php" class="block py-2 px-3 text-gray-700 hover:text-blue-500 border-b">Liên hệ</a></li>

  <?php if (isset($_COOKIE['loggedin']) && $_COOKIE['loggedin'] === 'true'): ?>
    <li><a href="../logout.php" class="block py-2 px-3 text-gray-700 hover:text-blue-500">Đăng xuất</a></li>
  <?php endif; ?>
</ul>

    </div>
  </div>
</header>

<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu-container');
    if (menu.style.width === '200px') {
        menu.style.width = '0';
        document.body.style.overflow = '';
    } else {
        menu.style.width = '200px';
        document.body.style.overflow = 'hidden';
    }
}
</script>
