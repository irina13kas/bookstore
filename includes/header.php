<?php
session_start();
$isLoggedIn = isset($_COOKIE['user_id']);
$error = $_SESSION['register_error'] ?? null;
unset($_SESSION['register_error']);
if($isLoggedIn){
  $userRole = $_COOKIE['user_role'];
}
else{
  $userRole = null;
}
$userName = 'Вы в системе';

if ($isLoggedIn) {
    require_once $_SERVER['DOCUMENT_ROOT'] .'/includes/connect_db.php';
    $stmt = $pdo->prepare("SELECT Name FROM user WHERE Id = ?");
    $stmt->execute([$_COOKIE['user_id']]);
    $row = $stmt->fetch();
    if ($row) {
        $userName = htmlspecialchars($row['Name']);
    }
}
?>
<header>
    <div class="container">
      <h1>В гостях у бабушки Кристи</h1>
      <nav>
        <ul>
          <li><a href="../index.php">Главная</a></li>
          <li><a href="../pages/about.php">О нас</a></li>
          <?php if($userRole==='User' || $userRole===null) : ?>
            <li><a href="../pages/catalog.php">Каталог</a></li>
            <li><a href="../pages/cart.php">Корзина</a></li>
            <li><a href="../pages/user_orders_history.php">Заказы</a></li>
          <?php elseif ($userRole==='Worker' || $userRole==='Admin'): ?>
            <li><a href="../pages/orders_worker.php">Заказы пользователей</a></li>
            <?php endif; ?>
          <?php if ($userRole==='Admin'): ?>
            <li><a href="../pages/edit_admin.php">Редактировать</a></li>
            <?php endif; ?>
        </ul>
      </nav>
      <div class="authorization">
        <button id="auth-btn"><?= $isLoggedIn ? $userName : 'Войти' ?></button>
        <?php if($userRole==='User' || $userRole===null) : ?>
          <button id="register-btn">Регистрация</button>
        <?php endif; ?>
      </div>
    </div>
  </header>

  <?php if (isset($_GET['error']) && $_GET['error'] === 'login_or_password_exists'): ?>
  <p class="error-msg" id="error-msg">Логин или пароль уже заняты. Пожалуйста, выберите другие.</p>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] === 'no_such_user'): ?>
  <p class="error-msg" id="error-msg">Нет такого пользователя.</p>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] === 'wrong_password'): ?>
  <p class="error-msg" id="error-msg">Неверный пароль.</p>
<?php endif; ?>

<script>
  setTimeout(() => {
    const msg = document.getElementById('error-msg');
    if (msg) {
      msg.remove();

      const url = new URL(window.location.href);
      url.searchParams.delete('error');
      window.history.replaceState({}, document.title, url.toString());
    }
  }, 5000);
</script>