<?php
require_once '../includes/connect_db.php';

$stmt = $pdo->prepare("SELECT * FROM view_catalog");
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>