<?php
session_start();
if($_SERVER['REQUEST_METHOD'] === 'POST'){
$bookId = $_POST['book_id'] ?? null;
$action = $_POST['action'] ?? null;
$postedQty = isset($_POST['qty']) ? (int)$_POST['qty'] : null;
$max_qty = (int)$_POST['max_qty'];

if ($bookId && isset($_SESSION['cart'][$bookId])) {
    $qty = $_SESSION['cart'][$bookId]['qty'];

    switch ($action) {
        case 'increase':
            $_SESSION['cart'][$bookId]['qty'] = $qty + 1;
            break;

        case 'decrease':
            if ($qty > 1) {
                $_SESSION['cart'][$bookId]['qty'] = $qty - 1;
            }
            break;

        case 'delete':
            unset($_SESSION['cart'][$bookId]);
            break;

        default:
            if ($postedQty >= 1 && $postedQty<=$max_qty) {
                $_SESSION['cart'][$bookId]['qty'] = $postedQty;
            }
            break;
    }
}

header("Location: ../pages/cart.php");
exit;
}
?>
