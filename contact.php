<?php
    include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<?php
    $errors = [];
    $fullname = $email = $subject = $content = "";
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $fullname = htmlspecialchars($_POST['fullname']);
        $email = htmlspecialchars($_POST['email']);
        $subject = htmlspecialchars($_POST['subject']);
        $content = htmlspecialchars($_POST['content']);

        if (empty($fullname)) {
        $errors['fullname'] = "Vui lòng nhập họ tên.";
        }

        if (empty($email)) {
        $errors['email'] = "Vui lòng nhập email.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email không hợp lệ.";
        }

        if (empty($subject)) {
        $errors['subject'] = "Vui lòng nhập chủ đề.";
        } elseif ((strlen($subject) < 6)) {
        $errors['subject'] = "Chủ đề phải ít nhất 6 ký tự.";
        }

        if (empty($content)) {
        $errors['content'] = "Vui lòng nhập nội dung.";
        }

        if (empty($errors)) {
            $sent_success = "$fullname đã gửi email đến chúng tôi. Trân trọng";
            setcookie("fullname_contact", $fullname, time() + (86400 * 30), "/");
            setcookie("email_contact", $email, time() + (86400 * 30), "/");
            setcookie("subject_contact", $subject, time() + (86400 * 30), "/");
            setcookie("content_contact", $content, time() + (86400 * 30), "/");
            $fullname = $email = $subject = $content = "";
        }
    }
?>
<body class="bg-blue-100"> 
    <main class="flex flex-col items-center justify-center min-h-screen text-center px-6">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6">Liên hệ với chúng tôi</h2>
            <?php
                if (!empty($sent_success)) {
                    echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md">
                            <p>' . htmlspecialchars($sent_success) . '</p>
                        </div>';
                }
            ?>            <form action="contact.php" method="POST">
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Họ và Tên</label>
                    <input type="text" placeholder="Nhập họ tên" name="fullname" value="<?php echo $fullname?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['fullname'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['fullname'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Email</label>
                    <input type="email" placeholder="Nhập email" name="email" value="<?php echo $email?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['email'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['email'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <div class="mb-4 text-left">
                    <label class="block text-gray-700">Chủ đề</label>
                    <input type="subject" placeholder="Nhập chủ đề" name="subject" value="<?php echo $subject?>" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php
                        if (isset($errors['subject'])) {
                            echo "<div style='color: red;'>";
                            echo $errors['subject'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <div class="mb-4 text-left">
                    <label class="block text-gray-700 font-medium mb-1">Nội dung</label>
                    <textarea name="content" placeholder="Nhập nội dung..." class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 h-32"></textarea>
                    <?php
                        if (isset($errors['content'])) {
                            echo "<div class='text-red-500 text-sm mt-1'>";
                            echo $errors['content'];
                            echo "</div>";
                        }
                    ?>
                </div>
                <button class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">Đăng Ký</button>
            </form>
        </div>  
    </main>
<?php
    include 'includes/footer.php';
?>
</body>
</html>