<?php
setcookie("fullname", "", time() - 3600, "/");
setcookie("loggedin", "", time() - 3600, "/");
setcookie("registered", "", time() - 3600, "/");
setcookie("role", "", time() - 3600, "/");
session_unset();
session_destroy();
header("Location: index.php");
exit;
?>
