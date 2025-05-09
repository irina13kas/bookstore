<?php
require_once '../includes/connect_db.php';
$title = $_POST['Title'] ?? '';

if (!empty($title)) {
    $stmt = $pdo->prepare("CALL get_books_by_title(?)");
    $stmt->execute([$title]);
    $books = $stmt->fetchAll();
} else {
    include "../includes/get_all_books.php";
}
?>