<?php
session_start();
require_once '../includes/connect_db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $total_cost = trim($_POST['total_cost'] ?? '');
    $_SESSION['user'] = [
        'name' => $name,
        'phone' => $phone,
        'email' => $email,
        'address' => $address
    ];
    $cart = $_SESSION['cart'] ?? [];
    if (empty($cart)) {
        die('Корзина пуста.');
    }

    try {
        $pdo->beginTransaction();
        $pdo->exec("INSERT INTO book_in_order (Book_id, Instnces) VALUES (1, 1)");
        $book_order_id = $pdo->lastInsertId();

        $pdo->prepare("DELETE FROM book_in_order WHERE Id = ?")->execute([$book_order_id]);


        foreach ($cart as $bookId => $item) {
            $qty = (int)$item['qty'];
            $stmt = $pdo->prepare("CALL add_to_book_order(?, ?, ?)");
            $stmt->execute([$book_order_id, $bookId, $qty]);
        }

        $stmt = $pdo->prepare("CALL create_order_record(?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $book_order_id,
            $_COOKIE['user_id'],                      
            $phone,
            $name,
            $email,
            $address,
            $total_cost           
        ]);

        
        $pdo->commit();
        include "template.php";
        unset($_SESSION['cart']);

    } catch (Exception $e) {
        echo 1111;
        $pdo->rollBack();
        echo "Ошибка при оформлении заказа: " . $e->getMessage();
    }
    header("Location: ../pages/cart.php");
    exit;
}
?>
