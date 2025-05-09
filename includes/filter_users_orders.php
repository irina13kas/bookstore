<?php
require_once '../includes/connect_db.php';

$status = $_GET['status'] ?? 'all';
$user_id = $_GET['User_id'] ?? null;

$user_id = $user_id !== '' ? $user_id : null;

$stmt = $pdo->prepare("CALL get_orders_filtered(?, ?)");
$stmt->execute([$status, $user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>