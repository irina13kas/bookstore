<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../includes/connect_db.php';
    $id = (int)$_POST['id'];
    $book_id = (int)$_POST['book_id'];
    $year = (int)$_POST['year'];
    $pages = (int)$_POST['pages'];
    $lang_id = (int)$_POST['lang_id'];
    $cover = $_POST['cover'];
    $publisher_id = (int)$_POST['publisher_id'];
    $price = (float)$_POST['price'];
    $instances = (int)$_POST['qty'];

$not_exists = $pdo->prepare("SELECT is_book_already_exist(?, ?, ?, ?, ?, ?, ?, ?)");
    $not_exists->bindValue(1, $book_id, PDO::PARAM_INT);
    $not_exists->bindValue(2, $year, PDO::PARAM_INT);
    $not_exists->bindValue(3, $pages, PDO::PARAM_INT);
    $not_exists->bindValue(4, $lang_id, PDO::PARAM_INT);
    $not_exists->bindValue(5, $cover, PDO::PARAM_STR);
    $not_exists->bindValue(6, $publisher_id, PDO::PARAM_INT);
    $not_exists->bindValue(7, $price, PDO::PARAM_INT);
    $not_exists->bindValue(8, $instances, PDO::PARAM_INT);
    $not_exists->execute();
if (!$not_exists) {
    echo "Такая книга уже существует.";
    exit;
}
echo $id;
$stmt = $pdo->prepare("CALL update_book(?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->bindValue(2, $book_id, PDO::PARAM_INT);
    $stmt->bindValue(3, $year, PDO::PARAM_INT);
    $stmt->bindValue(4, $pages, PDO::PARAM_INT);
    $stmt->bindValue(5, $lang_id, PDO::PARAM_INT);
    $stmt->bindValue(6, $cover, PDO::PARAM_STR);
    $stmt->bindValue(7, $publisher_id, PDO::PARAM_INT);
    $stmt->bindValue(8, $price, PDO::PARAM_INT);
    $stmt->bindValue(9, $instances, PDO::PARAM_INT);
    $stmt->execute();
}
header ('Location: ../pages/edit_admin.php');
exit;
?>