<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_COOKIE['user_id'])) {
require_once '../includes/connect_db.php';
$userId = (int)$_COOKIE['user_id'];
$filter = $_GET['filter'] ?? 'all';
try {
    $stmt = $pdo->prepare("CALL get_user_orders_by_filter(:user_id, :filter)");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':filter', $filter, PDO::PARAM_STR);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
} catch (PDOException $e) {
    die("Ошибка запроса: " . $e->getMessage());
}
}
?>