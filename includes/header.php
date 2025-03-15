<header class="bg-white shadow-md p-4">
    <div class="container mx-auto flex justify-between items-center px-6 md:px-20">
        <h1 class="text-xl font-bold">
            <img src="../assets/images/thecao5s.png" alt="Logo" class="h-12 w-auto">
        </h1>
        <nav>
            <button class="md:hidden text-gray-700 focus:outline-none" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                ☰
            </button>
            <ul id="mobile-menu" class="hidden md:flex flex-col md:flex-row md:space-x-0 absolute md:static bg-white md:bg-transparent w-full md:w-auto left-0 top-16 shadow-md md:shadow-none">
                <li><a href="../index.php" class="block py-2 px-4 text-gray-700 hover:text-blue-500">Trang Chủ</a></li>
                <li><a href="../products/index.php" class="block py-2 px-4 text-gray-700 hover:text-blue-500">Sản phẩm</a></li>
                <li><a href="../contact.php" class="block py-2 px-4 text-gray-700 hover:text-blue-500">Liên Hệ</a></li>
                <li><a href="../login.php" class="block py-2 px-4 text-gray-700 hover:text-blue-500">
                <?php
                    if (isset($_COOKIE['loggedin']) && $_COOKIE['loggedin'] === "true" && isset($_COOKIE['fullname'])) {
                        echo "Hello " . htmlspecialchars($_COOKIE['fullname']);
                    } else {
                        echo "Đăng nhập";
                    }
                ?>
                </a></li>
                <?php
                    if (isset($_COOKIE['loggedin']) && $_COOKIE['loggedin'] === "true") {
                        echo '<li><a href="../logout.php" class="block py-2 px-4 text-gray-700 hover:text-blue-500">Đăng xuất</a></li>';
                    }
                ?>
            </ul>
        </nav>
    </div>
</header>