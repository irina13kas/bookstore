<?php
require_once '../includes/connect_db.php';

if ($_COOKIE['user_role'] === 'User') {
    header('Location: ../index.php');
    exit;
}

$orderId = $_POST['order_id'];
$newStatus = $_POST['new_status'];

$stmt = $pdo->prepare("UPDATE order_online SET status = ? WHERE Order_id = ?");
$stmt->execute([$newStatus, $orderId]);

header('Location: ../pages/orders_worker.php');
exit;
