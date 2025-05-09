<?php
session_start();
require_once '../includes/connect_db.php';

$books = $pdo->query("SELECT * FROM view_catalog")->fetchAll();
$abstract_books = $pdo->query("SELECT Id, Title FROM view_titles")->fetchAll();
$languages = $pdo->query("SELECT Id, Lang FROM view_languages")->fetchAll();
$covers = ['Мягкая','Твердая'];
$publishers = $pdo->query("SELECT Id, Name FROM view_publishers")->fetchAll();
 ?>