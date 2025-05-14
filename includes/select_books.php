<?php
include "filter.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_button'])) {
        echo $_POST['city'];
    $publishers = isset($_POST['publisher']) ? implode(',', $_POST['publisher']) : null;
    $detectives = isset($_POST['detective']) ? implode(',', $_POST['detective']) : null;
$stmt = $pdo->prepare("CALL get_filtered_books(:search, :city, :lang, :publisher, :detective, :heroName, :method)");
$stmt->execute([
    ':search' => $_POST['search'] ?: null,
    ':city' => $_POST['city'] ?: null,
    ':lang' => $_POST['language'] ?: null,
    ':publisher' => $publishers,
    ':detective' => $detectives,
    ':heroName' => $_POST['heroName'] ?: null,
    ':method' => $_POST['method'] ?: null
]);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>