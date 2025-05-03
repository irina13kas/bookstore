<?php
$isLoggedIn = isset($_COOKIE['user_id']);
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
      <button id="auth-btn"><?= $isLoggedIn ? 'Вы в системе' : 'Войти' ?></button>
    </div>
  </header>