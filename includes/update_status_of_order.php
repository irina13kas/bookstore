<?php
require_once '../includes/connect_db.php';

if ($_COOKIE['user_role'] !== 'Worker') {
    header('Location: ../index.php');
    exit;
}

$orderId = $_POST['order_id'];
$newStatus = $_POST['new_status'];

$stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE Id = ?");
$stmt->execute([$newStatus, $orderId]);

header('Location: ../pages/orders_worker.php');
exit;
