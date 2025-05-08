<?php
require_once '../includes/db.php';

if ($_COOKIE['user_role'] !== 'Worker') {
    header("Location: ../index.php");
    exit;
}

$orderId = $_POST['order_id'];
$stmt = $pdo->prepare("CALL delete_order_by_id(?)");
$stmt->execute([$orderId]);

header("Location: orders_worker.php");
exit;
?>