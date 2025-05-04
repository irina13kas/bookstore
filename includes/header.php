<?php
$isLoggedIn = isset($_COOKIE['user_id']);
$error = $_SESSION['register_error'] ?? null;
unset($_SESSION['register_error']);
?>
<header>
    <div class="container">
      <h1>В гостях у бабушки Кристи</h1>
      <nav>
        <ul>
          <li><a href="../index.php">Главная</a></li>
          <li><a href="../pages/catalog.php">Каталог</a></li>
          <li><a href="../pages/about.php">О нас</a></li>
          <li><a href="../pages/cart.php">Корзина</a></li>
        </ul>
      </nav>
      <div class="authorization">
        <button id="auth-btn"><?= $isLoggedIn ? 'Вы в системе' : 'Войти' ?></button>
        <button id="register-btn">Регистрация</button>
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