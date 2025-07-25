<?php
session_start();
require_once 'connect_db.php';

$login = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';
$redirect = $_POST['redirect'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM view_all_users WHERE Login = ?");
$stmt->execute([$login]);
$user = $stmt->fetch();

if(!$user){
    header("Location: ../$redirect.?error=no_such_user");
  exit;
}

if ($user && $password===$user['Password']) {
    setcookie("user_id", $user['Id'], time() + 3600, "/");
    setcookie('user_role', $user['Role'], time() + 3600, '/');
    header("Location: ../$redirect");
    exit;
} else {
    header("Location: ../index.php?error=wrong_password");
    exit;
}

?>