<div class="wrapper">
<footer>
<div class="container">
  <p>&copy; 2025 В гостях у бабушки Кристи. Все права защищены.</p>
  <nav>
    <a href="../index.php">Главная</a> |
    <a href="../pages/about.php">О нас</a> |
    <?php if($userRole==='User' || $userRole===null) : ?>
    <a href="../pages/catalog.php">Каталог</a> |
    <a href="../pages/cart.php">Корзина</a> |
    <a href="../pages/user_orders_history.php">Заказы</a>
    <?php elseif ($userRole==='Worker' || $userRole==='Admin'): ?>
    <a href="../pages/orders_worker.php">Заказы пользователей</a>
    <?php endif; ?>
    <?php if ($userRole==='Admin'): ?>
    <a href="../pages/edit_admin.php">Редактировать</a>
    <?php endif; ?>
  </nav>
</div>
</footer>
</div>