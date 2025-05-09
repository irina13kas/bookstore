<?php
require_once '../includes/connect_db.php';

$type = $_GET['type'] ?? 'online';

if ($type === 'offline') {
    $stmt = $pdo->prepare("SELECT * FROM view_orders_offline");
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $status = $_GET['status'] ?? 'all';
    $user_id = $_GET['User_id'] ?? null;
    $user_id = $user_id !== '' ? $user_id : null;

    $stmt = $pdo->prepare("CALL get_orders_filtered(?, ?)");
    $stmt->execute([$status, $user_id]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>