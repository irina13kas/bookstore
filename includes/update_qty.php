<?php
session_start();
if($_SERVER['REQUEST_METHOD'] === 'POST'){
$bookId = $_POST['book_id'] ?? null;
$action = $_POST['action'] ?? null;
$postedQty = isset($_POST['qty']) ? (int)$_POST['qty'] : null;
$max_qty = (int)$_POST['max_qty'];

if ($bookId && isset($_SESSION['cart'][$bookId])) {
    $qty = $_SESSION['cart'][$bookId]['qty'];
    echo 111;
    switch ($action) {
        case 'increase':
            $_SESSION['cart'][$bookId]['qty'] = $qty + 1;
            echo 2;
            break;

        case 'decrease':
            if ($qty > 1) {
                $_SESSION['cart'][$bookId]['qty'] = $qty - 1;
                echo 3;
            }
            break;

        case 'delete':
            unset($_SESSION['cart'][$bookId]);
            echo 4;
            break;

        default:
            if ($postedQty >= 1 && $postedQty<=$max_qty) {
                echo 5;
                $_SESSION['cart'][$bookId]['qty'] = $postedQty;
            }
            break;
    }
}

    header("Location: ../includes/offline_order_checkout.php");


exit;
}
?>
