<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
require_once '../includes/connect_db.php';

$userId = isset($_COOKIE['user_id']) ? (int)$_COOKIE['user_id'] : null;

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

$books = [];
foreach ($cart as $bookId => $item) {
    $books[] = [
        'book_id' => (int)$bookId,
        'qty' => (int)$item['qty']
    ];
}

try {
    $stmt = $pdo->prepare("CALL create_order_with_stock_check(?, ?, ?, ?, ?, ?, ?)");
    $stmt->bindValue(1, $userId, PDO::PARAM_INT);
    $stmt->bindValue(2, $name, PDO::PARAM_STR);
    $stmt->bindValue(3, $phone, PDO::PARAM_STR);
    $stmt->bindValue(4, $email, PDO::PARAM_STR);
    $stmt->bindValue(5, $address, PDO::PARAM_STR);
    $stmt->bindValue(6, $total_cost, PDO::PARAM_INT);
    $stmt->bindValue(7, json_encode($books), PDO::PARAM_STR);

    $stmt->execute();

    include "template.php";
    include "send_order.php";
    unset($_SESSION['cart']);
    unset($_SESSION['user']);
    unset($_SESSION['order_datails']);
    header("Location: ../pages/cart.php?success=1");
    exit;
} catch (PDOException $e) {
    $errorMessage = $e->getMessage();
    header("Location: ../pages/cart.php?error=" . urlencode($errorMessage));
    exit;
}
}
?>
