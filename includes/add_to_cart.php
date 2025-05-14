<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $qty = (int)($_POST['qty'] ?? 1);
    $max_qty = (int)($_POST['max_qty'] ?? 1);
    $price = (int)($_POST['price'] ?? 0);
    $book_id = (int)($_POST['book_id'] ?? 0);  
if($book_id!==0){
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$book_id]) && $_SESSION['cart'][$book_id]['qty']+$qty<=$max_qty) {
        $_SESSION['cart'][$book_id]['qty'] += $qty;
    } else {
        $_SESSION['cart'][$book_id] = [
            'title' => $title,
            'qty' => $qty,
            'max_qty' => $max_qty,
            'price' => $price
        ];
    }
    $_SESSION['success'] = "Книга \"$title\" ($qty шт.) успешно добавлена в корзину.";
}
}
?>
