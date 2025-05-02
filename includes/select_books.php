<?php
include "filter.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_button'])) {
$stmt = $pdo->prepare("CALL get_filtered_books(:search, :country, :city, :lang, :publisher, :detective, :heroName)");
echo $_POST['search'];
$stmt->execute([
    ':search' => $_POST['search'] ?: null,
    ':country' => $_POST['country'] ?: null,
    ':city' => $_POST['city'] ?: null,
    ':lang' => $_POST['language'] ?: null,
    ':publisher' => $_POST['publisher'][0] ?? null,
    ':detective' => $_POST['detective'][0] ?? null,
    ':heroName' => $_POST['heroName'] ?: null
]);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>