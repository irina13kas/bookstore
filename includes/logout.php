<?php
// Удаляем cookie
setcookie('user_id', '', time() - 3600, '/'); 

session_start();
session_unset();
session_destroy();

header("Location: ../index.php");
exit;
