<?php
session_start();
$filter = $_GET['filter'] ?? 'all';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>В гостях у бабушки Кристи</title>
  <link rel="icon" href="/assets/images/icon.ico" type="image/x-icon">
  <link rel="stylesheet" href="/styles/style.css">
</head>

<body>
<?php include('../includes/header.php'); ?>
<?php include('../includes/authorization_form.php'); ?>
<?php include('../includes/get_user_orders.php'); ?>
<main class="catalog-page">
  <div class="container">
  <h2>Мои заказы</h2>
  <?php if (!isset($_COOKIE['user_id'])): ?>
    <h3>Необходимо войти в систему.</h3>
    <?php  $_SESSION = []; ?>
    <?php  session_destroy(); ?>
    <?php else: ?>
  <form method="get" class="filter-form">
    <label for="filter">Показать:</label>
    <select name="filter" id="filter" onchange="this.form.submit()">
      <option value="all" <?= $filter === 'all' ? 'selected' : '' ?>>Все</option>
      <option value="current" <?= $filter === 'current' ? 'selected' : '' ?>>Текущие</option>
      <option value="completed" <?= $filter === 'completed' ? 'selected' : '' ?>>Выполненные</option>
    </select>
  </form>

  <?php if (empty($orders)): ?>
    <div class="no-orders">У вас пока нет заказов.</div>
  <?php else: ?>
    <?php foreach ($orders as $order): ?>
        <?php $class = ($order['Status'] === 'Завершен') ? 'order-completed' : 'order-current';?>
  <div class="order-card <?= $class ?>">
        <h3>Заказ №<?= htmlspecialchars($order['order_id']) ?></h3>
        <div class="order-info">Получатель: <?= htmlspecialchars($order['Name']) ?></div>
        <div class="order-info">Почта: <?= htmlspecialchars($order['Email']) ?></div>
        <div class="order-info">Телефон: <?= htmlspecialchars($order['Phone']) ?></div>
        <div class="order-info">Дата оформления: <?= htmlspecialchars($order['Date']) ?></div>
        <div class="order-info">Статус: <?= htmlspecialchars($order['Status']) ?></div>
        <div class="order-books">Книги: <?= htmlspecialchars($order['books']) ?></div>
        <div class="order-info"><strong>Сумма заказа:</strong> <?= htmlspecialchars($order['Total_cost']) ?> ₽</div>
      </div>
    <?php endforeach; ?>
    </div>
  <?php endif; ?>
  <?php endif; ?>
  </main>
  <?php include('../includes/footer.php'); ?>
</body>
</html>
