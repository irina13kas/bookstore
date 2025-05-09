<?php 
    $host = 'MySQL-8.2';
    $db   = 'bookshop';
    $user = 'root';
    $pass = '';
    $charset = 'utf8'; 
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
?>