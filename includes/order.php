<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
require_once '../includes/connect_db.php';

$userId = isset($_COOKIE['user_id']) ? (int)$_COOKIE['user_id'] : null;

$cart = $_SESSION['cart'];
$name = $_SESSION['user']['name'];
$phone = $_SESSION['user']['phone'];
$email = $_SESSION['user']['email'];
$address = $_SESSION['user']['address'];
$totalCost = $_POST['total_cost'];

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
    $stmt->bindValue(6, $totalCost, PDO::PARAM_INT);
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
