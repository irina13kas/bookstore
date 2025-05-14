<?php
require_once '../includes/connect_db.php';

if ($_COOKIE['user_role'] === 'User') {
    header("Location: ../index.php");
    exit;
}

$orderId = $_POST['order_id'];
$stmt = $pdo->prepare("CALL delete_order_by_id(?)");
$stmt->execute([$orderId]);

header("Location: ../pages/orders_worker.php");
exit;
?>