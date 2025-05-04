<?php
session_start();
require_once 'connect_db.php';

$name = $_POST['name'] ?? '';
$login = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';
$redirect = $POST['redirect'];

$stmt = $pdo->prepare("SELECT * FROM view_all_users WHERE Login = ? OR Password = ?");
$stmt->execute([$login, $password]);
if ($stmt->fetch()) {
  header("Location: ../$redirect.?error=login_or_password_exists");
  exit;
}

$stmt = $pdo->prepare("CALL register_user(?, ?, ?)");
$stmt->execute([$name, $login, $password]);

$user_id = $pdo->lastInsertId();
setcookie("user_id", $user_id, time() + 3600, "/");
header("Location: ../$redirect");
exit;
?>
