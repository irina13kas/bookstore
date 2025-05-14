<?php 
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_ids'])) {
    require_once '../includes/connect_db.php';
if (!empty($_POST['delete_ids'])) {
    $ids = $_POST['delete_ids'];

    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    // SQL-вызов процедуры или функции, например:
    $stmt = $pdo->prepare("CALL delete_book_by_id(:id)");

    foreach ($ids as $id) {
        $stmt->execute(['id' => $id]);
    }
}
}
    header("Location: ../pages/edit_admin.php");
    exit;
?>