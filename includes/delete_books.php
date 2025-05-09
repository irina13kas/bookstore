<?php 
session_start();
if (isset($_POST['delete_selected']) && !empty($_POST['selected_books'])) {
    require_once '../includes/connect_db.php';
    foreach ($_POST['selected_books'] as $bookId) {
        $stmt = $pdo->prepare("CALL delete_printed_book(?)");
        $stmt->execute([$bookId]);
    }
}
    header("Location: ../pages/edit_admit.php");
    exit;
?>