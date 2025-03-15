<?php
setcookie("fullname", "", time() - 3600, "/");
setcookie("email", "", time() - 3600, "/");
setcookie("password", "", time() - 3600, "/");
setcookie("loggedin", "", time() - 3600, "/");
header("Location: index.php");
exit;
?>
