<?php
session_start();
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])){
$bookId = $_POST['book_id'] ?? null;
$action = $_POST['action'] ?? null;

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
    }
}

header("Location: ../pages/cart.php");
exit;
}
?>
