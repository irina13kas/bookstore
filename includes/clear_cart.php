<?php
session_start();
unset($_SESSION['cart']);
header("Location: ../pages/cart.php");
exit;
?>