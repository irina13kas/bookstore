<?php
session_start();
if (isset($_POST['update_stock'])) {
    require_once '../includes/connect_db.php';
    $id = $_POST['book_id'];
    $inc = $_POST['increase'];
    $stmt = $pdo->prepare("CALL increase_book_stock(?, ?)");
    $stmt->execute([$id, $inc]);
}
    header("Location: ../pages/edit_admit.php");
    exit;
 ?>