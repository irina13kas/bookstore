<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
$total = 0;
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
<?php include('../includes/update_cart.php'); ?>
  <div class="cart-container">

<h2>Корзина</h2>
<?php if (isset($_COOKIE['user_id'])): ?>
<?php if (empty($cart)): ?>
  <p>Корзина пуста.</p>
<?php else: ?>
  <ul>
  <?php foreach ($cart as $bookId => $item): 
        $title = $item['title'];
        $qty = (int)$item['qty'];
        $price = (int)$item['price'];
        $itemTotal = $price * $qty;
        $total += $itemTotal;
    ?>
       <li class="cart-item">
  <span class="cart-title"><?= htmlspecialchars($title) ?></span>

  <form method="post" action="../includes/update_cart.php" class="qty-form">
    <input type="hidden" name="book_id" value="<?= $bookId ?>">
    <button type="submit" name="action" value="decrease" <?= $qty <= 1 ? 'disabled' : '' ?>>-</button>
    <input type="number" name="qty" value="<?= $qty ?>" readonly>
    <button type="submit" name="action" value="increase">+</button>
  </form>

  <span class="cart-price"><?= $price ?> ₽</span>
  <span class="cart-total"><?= $price * $qty ?> ₽</span>

  <form method="post" action="../includes/update_cart.php" class="delete-form">
    <input type="hidden" name="book_id" value="<?= $bookId ?>">
    <button type="submit" name="action" value="delete" class="delete-btn">Удалить</button>
  </form>
</li>

    <?php endforeach; ?>
  </ul>
  <div class="cart-summary">
  <strong>Итого: <?= $total ?> ₽</strong>
</div>
<?php if (!empty($cart)): ?>
  <form class="order-form" method="post" action="../includes/order.php">
    <h3>Оформление заказа</h3>
    <label>Имя: <input type="text" name="name" required></label><br><br>
    <label>Телефон: <input type="tel" name="phone" required></label><br><br>
    <label>Почта: <input type="email" name="email" required></label><br><br>
    <label>Адрес: <textarea name="address" required></textarea></label><br><br>
    <input type="hidden" name="total_cost" value="<?= $total ?>">
    <button type="submit" name="checkout" class="order-btn">Оформить заказ</button>
  </form>
<?php endif; ?>
<?php endif; ?>
<form method="post" action="../includes/clear_cart.php">
<button type="submit" class="clear-btn">Очистить корзину</button>
</form>
<?php else: ?>
  <h3>Необходимо войти в систему.</h3>
<?php endif; ?>
</div>
<?php include('../includes/footer.php'); ?>
</body>
</html>