<?php
require_once '../includes/connect_db.php';

// Проверяем, есть ли кука с ролью
if ($_COOKIE['user_role'] !== 'Worker') {
    // Если роль не работник, доступ запрещен
    header('Location: ../pages/index.php');
    exit;
}

$orderId = $_POST['order_id'];
$newStatus = $_POST['new_status'];

$stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE Id = ?");
$stmt->execute([$newStatus, $orderId]);

header('Location: ../pages/orders_worker.php');
exit;
