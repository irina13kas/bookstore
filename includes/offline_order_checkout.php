<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
$total = 0;
$userRole = $_COOKIE['user_role'] ?? null;
if ($userRole !== 'Worker') {
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>В гостях у бабушки Кристи</title>
  <link rel="icon" href="/assets/images/icon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
<?php include('../includes/header.php'); ?>
<?php include('../includes/authorization_form.php'); ?>
  <div class="cart-container">
<?php if (isset($_GET['error'])): ?>
  <p class="error-msg"><?= htmlspecialchars($_GET['error']) ?></p>
<?php else:?>
  <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
  <p style="color: green;">Заказ успешно оформлен!</p>
<?php endif; ?>
<?php endif; ?>
<h2>Оформление заказа покупателя</h2>
<?php if (empty($cart)): ?>
  <p>Нет заказов</p>
<?php else: ?>
  <ul>
  <?php foreach ($cart as $bookId => $item): 
        $title = $item['title'];
        $qty = (int)$item['qty'];
        $max_qty = (int)$item['max_qty'];
        $price = (int)$item['price'];
        $itemTotal = $price * $qty;
        $total += $itemTotal;
    ?>
       <li class="cart-item">
  <span class="cart-title"><?= htmlspecialchars($title) ?></span>

  <form method="post"  class="qty-form" action="../includes/update_qty.php">
    <input type="hidden" name="book_id" value="<?= $bookId ?>">
    <input type="hidden" name="qty" value="<?= $qty ?>">
    <input type="hidden" name="max_qty" value="<?= $max_qty ?>">
    <button type="submit" name="action" value="decrease" <?= $qty <= 1 ? 'disabled' : '' ?>>-</button>
    <input type="number" name="qty" value="<?= $qty ?>" max="<?= $max_qty?>" onchange="this.form.submit()">
    <button type="submit" name="action" value="increase" <?= $qty >=$max_qty ? 'disabled' : '' ?>>+</button>
  </form>

  <span class="cart-price"><?= $price ?> ₽</span>
  <span class="cart-total"><?= $price * $qty ?> ₽</span>

  <form method="post" action="../includes/update_qty.php" class="delete-form">
    <input type="hidden" name="book_id" value="<?= $bookId ?>">
    <button type="submit" name="action" value="delete" class="delete-btn">Удалить</button>
  </form>
</li>

    <?php endforeach; ?>
  </ul>
  <div class="cart-summary">
  <strong>Итого: <?= $total ?> ₽</strong>
</div>
<?php endif; ?>
<?php if (!empty($cart)): ?>
<form method="post" action="../includes/clear_cart.php">
<button type="submit" class="clear-btn">Удалить заказ</button>
</form>
<form method="post" action="offline_order_select_books.php">
    <button type="submit" class="btn-next">Назад</button>
  </form>
  <form method="post" action="offline_order_submit.php">
    <input type="hidden" name="total_cost" value="<?= $total ?>">
    <button type="submit" class="btn-next">Оформить заказ</button>
  </form>
  <?php endif; ?>
</div>
<?php include('../includes/footer.php'); ?>
</body>
</html>