<header class="bg-white shadow-md p-4">
    <div class="container mx-auto px-6 md:px-20">
        <!-- Mobile view: flex with hamburger on left, logo in center -->
        <div class="flex md:hidden items-center justify-between w-full">
            <button class="text-gray-700 focus:outline-none" onclick="toggleMobileMenu()">
                ☰
            </button>
            <h1 class="text-xl font-bold">
                <img src="../assets/images/logo/thecao5s.png" alt="Logo" class="h-12 w-auto">
            </h1>
            <div class="w-6"><!-- Empty div for balanced spacing --></div>
        </div>
        
        <!-- Desktop view: logo on left, navigation on right -->
        <div class="hidden md:flex justify-between items-center">
            <h1 class="text-xl font-bold">
                <img src="../assets/images/logo/thecao5s.png" alt="Logo" class="h-12 w-auto">
            </h1>
            <nav>
                <ul id="desktop-menu" class="flex flex-row space-x-2">
                    <li><a href="../index.php" class="block py-2 px-4 text-gray-700 hover:text-blue-500">Trang Chủ</a></li>
                    <li><a href="../products/index.php" class="block py-2 px-4 text-gray-700 hover:text-blue-500">Sản phẩm</a></li>
                    <li><a href="../users/index.php" class="block py-2 px-4 text-gray-700 hover:text-blue-500">Người dùng</a></li>
                    <li><a href="../profile.php" class="block py-2 px-4 text-gray-700 hover:text-blue-500">
                    <?php
                        if (isset($_COOKIE['loggedin']) && $_COOKIE['loggedin'] === "true" && isset($_COOKIE['fullname'])) {
                            echo "Hello " . htmlspecialchars($_COOKIE['fullname']);
                        } else {
                            echo "Đăng nhập";
                        }
                    ?>
                    </a></li>
                    <li><a href="../contact.php" class="block py-2 px-4 text-gray-700 hover:text-blue-500">Liên hệ</a></li>
                    <?php
                        if (isset($_COOKIE['loggedin']) && $_COOKIE['loggedin'] === "true") {
                            echo '<li><a href="../logout.php" class="block py-2 px-4 text-gray-700 hover:text-blue-500">Đăng xuất</a></li>';
                        }
                    ?>
                </ul>
            </nav>
        </div>
    </div>
    
    <!-- Mobile menu (hidden by default) with slide effect -->
    <div id="mobile-menu-container" class="fixed left-0 top-0 h-full w-0 bg-white shadow-lg overflow-x-hidden transition-all duration-300 z-50">
        <div class="pt-16 px-4">
            <button onclick="toggleMobileMenu()" class="absolute top-4 right-4 text-gray-700 focus:outline-none text-xl">
                &times;
            </button>
            <ul id="mobile-menu" class="flex flex-col w-full">
                <li><a href="../index.php" class="block py-3 px-4 text-gray-700 hover:text-blue-500 border-b">Trang Chủ</a></li>
                <li><a href="../products/index.php" class="block py-3 px-4 text-gray-700 hover:text-blue-500 border-b">Sản phẩm</a></li>
                <li><a href="../users/index.php" class="block py-3 px-4 text-gray-700 hover:text-blue-500 border-b">Người dùng</a></li>
                <li><a href="../profile.php" class="block py-3 px-4 text-gray-700 hover:text-blue-500 border-b">
                <?php
                    if (isset($_COOKIE['loggedin']) && $_COOKIE['loggedin'] === "true" && isset($_COOKIE['fullname'])) {
                        echo "Hello " . htmlspecialchars($_COOKIE['fullname']);
                    } else {
                        echo "Đăng nhập";
                    }
                ?>
                </a></li>
                <li><a href="../contact.php" class="block py-3 px-4 text-gray-700 hover:text-blue-500 border-b">Liên Hệ</a></li>
                <?php
                    if (isset($_COOKIE['loggedin']) && $_COOKIE['loggedin'] === "true") {
                        echo '<li><a href="../logout.php" class="block py-3 px-4 text-gray-700 hover:text-blue-500">Đăng xuất</a></li>';
                    }
                ?>
            </ul>
        </div>
    </div>
</header>

<script>
function toggleMobileMenu() {
    const menuContainer = document.getElementById('mobile-menu-container');
    if (menuContainer.style.width === '200px') {
        menuContainer.style.width = '0';
        // Enable scrolling on the body when menu closes
        document.body.style.overflow = '';
    } else {    
        menuContainer.style.width = '200px';
        // Disable scrolling on the body when menu is open
        document.body.style.overflow = 'hidden';
    }
}
</script>