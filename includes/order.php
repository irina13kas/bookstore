<?php
session_start();
require_once '../includes/connect_db.php'; // подключение к БД
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $total_cost = trim($_POST['total_cost'] ?? '');
    $cart = $_SESSION['cart'] ?? [];
    if (empty($cart)) {
        die('Корзина пуста.');
    }

    try {
        $pdo->beginTransaction();
        //вынести в отдельную функцию
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
            1,                      
            $phone,
            $name,
            $email,
            $address,
            $total_cost           
        ]);

        
        $pdo->commit();

        unset($_SESSION['cart']);

        echo "<p style='text-align:center; font-size:20px;'>Ваш заказ оформлен и отправлен в обработку!</p>";
        echo "<p style='text-align:center;'><a href='catalog.php'>Вернуться в каталог</a></p>";

    } catch (Exception $e) {
        echo 1111;
        $pdo->rollBack();
        echo "Ошибка при оформлении заказа: " . $e->getMessage();
    }
    header("Location: ../pages/cart.php");
    exit;
}
?>
