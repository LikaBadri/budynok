<?php
setcookie("StudCookie", false, 0, "/");  /* срок действия 1 час */
setcookie("AdminCookie", false, 0, "/");  /* срок действия 1 час */
setcookie("GuideCookie", false, 0, "/");  /* срок действия 1 час */
header("Location: Home.php");
?>