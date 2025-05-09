<?php 
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
require_once '../includes/connect_db.php';

$employee_id = isset($_COOKIE['user_id']) ? (int)$_COOKIE['user_id'] : null;
$total_cost = (int)$_POST['total_cost'] ?? 0;

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    die('Корзина пуста.');
}

$books = [];
foreach ($cart as $bookId => $item) {
    $books[] = [
        'book_id' => (int)$bookId,
        'qty' => (int)$item['qty']
    ];
}
try {
$stmt = $pdo->prepare("CALL create_offline_order_with_stock_check(?, ?, ?)");
    $stmt->bindValue(1, $employee_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $total_cost, PDO::PARAM_INT);
    $stmt->bindValue(3, json_encode($books), PDO::PARAM_STR);

    $stmt->execute();  
    unset($_SESSION['cart']);
    header("Location: ../includes/offline_order_checkout.php?success=1");
    exit;
}   catch (PDOException $e) {
    $errorMessage = $e->getMessage();
    header("Location: ../include/offline_order_checkout.php?error=" . urlencode($errorMessage));
    exit;
}
}
?>