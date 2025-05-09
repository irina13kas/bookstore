<?php
session_start();

$userRole = $_COOKIE['user_role'] ?? null;

if ($userRole !== 'Worker') {
    header('Location: ../pages/index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>О нас — В гостях у бабушки Кристи</title>
  <link rel="icon" href="/assets/images/icon.ico" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../styles/style.css">
</head>
<body>

<?php include('../includes/header.php'); ?>
  <div class="container">

<h2>Заказы: </h2>
<button type="submit" class="btn-next" onclick="location.href='../includes/new_order_select_books.php'">
  Оформить новый заказ
</button>
<form method="get" style="margin-bottom: 20px;" class="order-card-worker">
  <input type="hidden" name="User_id" value="<?= htmlspecialchars($_GET['User_id'] ?? '') ?>">
  <input type="hidden" name="status" value="<?= htmlspecialchars($_GET['status'] ?? '') ?>">

  <button type="submit" name="type" value="online" class="btn-type <?= ($_GET['type'] ?? 'online') === 'online' ? 'active' : '' ?>">Онлайн-заказы</button>
  <button type="submit" name="type" value="offline" class="btn-type <?= ($_GET['type'] ?? 'online') === 'offline' ? 'active' : '' ?>">Оффлайн-заказы</button>
</form>
<form method="get" class="form-order-worker">
  <fieldset>
    <legend>ID пользователя:</legend>
    <input type="text" name="User_id" placeholder="Введите ID пользователя" value="<?= htmlspecialchars($_GET['User_id'] ?? '') ?>">
  </fieldset>

  <select class="select-order-worker" name="status" onchange="this.form.submit()">
    <option value="all">Все</option>
    <option value="В обработке" <?= ($_GET['status'] ?? '') === 'В обработке' ? 'selected' : '' ?>>В обработке</option>
    <option value="Оформлен" <?= ($_GET['status'] ?? '') === 'Оформлен' ? 'selected' : '' ?>>Оформлен</option>
    <option value="Доставка" <?= ($_GET['status'] ?? '') === 'Доставка' ? 'selected' : '' ?>>Доставка</option>
    <option value="Завершен" <?= ($_GET['status'] ?? '') === 'Завершен' ? 'selected' : '' ?>>Завершен</option>
  </select>

  <button type="submit" name="search">Поиск</button>
</form>
<?php include("../includes/filter_users_orders.php"); ?>
<?php
$type = $_GET['type'] ?? 'online';

if (count($orders) === 0) {
    echo "<p>Нет заказов</p>";
} else {
    if ($type === 'offline') {
      $grouped = [];
         foreach ($orders as $order) {
            $grouped[$order['Id']][] = $order;
        }
           foreach ($grouped as $order_id => $items):
            $info = $items[0];
         ?>
          <div class="order-card-worker offline">
            <p><b>Order ID:</b> <?= $info['Id'] ?></p>
            <p><b>Сотрудник:</b> <?= htmlspecialchars($info['Worker']) ?></p>
            <p><b>Дата:</b> <?= $info['Date'] ?></p>
            <p><b>Книги:</b></p>
            <ul>
            <?php foreach ($items as $book): ?>
                <li><?= htmlspecialchars($book['Book']) ?> (x<?= $book['Instances'] ?>)</li>
              <?php endforeach; ?>
            </ul>
            <p><b>Стоимость:</b> <?= $order['Total_cost'] ?> ₽</p>
            <form method="post" action="delete_order.php" class="delete-form" onsubmit="return confirm('Удалить заказ?');">
              <input type="hidden" name="order_id" value="<?= $order['Id'] ?>">
              <button type="submit">Удалить заказ</button>
            </form>
          </div>
        <?php endforeach;

    } else {
        $grouped = [];
        foreach ($orders as $order) {
            $grouped[$order['Id']][] = $order;
        }

        foreach ($grouped as $order_id => $items):
            $info = $items[0];
        ?>
          <div class="order-card-worker <?= $info['Status'] === 'Завершен' ? 'archived' : 'active' ?>">
            <p><b>Order ID:</b> <?= $order_id ?></p>
            <p><b>User ID:</b> <?= $info['User'] ?></p>
            <p><b>Получатель:</b> <?= htmlspecialchars($info['Receiver'] ?? '-') ?></p>
            <p><b>Email:</b> <?= htmlspecialchars($info['Email'] ?? '-') ?></p>
            <p><b>Телефон:</b> <?= htmlspecialchars($info['Phone'] ?? '-') ?></p>
            <p><b>Адрес:</b> <?= htmlspecialchars($info['Address'] ?? '-') ?></p>
            <p><b>Дата:</b> <?= $info['Date'] ?></p>
            <p><b>Статус:</b> <?= $info['Status'] ?></p>
            <p><b>Книги:</b></p>
            <ul>
              <?php foreach ($items as $book): ?>
                <li><?= htmlspecialchars($book['Title of book']) ?> (x<?= $book['Instances'] ?>)</li>
              <?php endforeach; ?>
            </ul>
            <p><b>Полная стоимость:</b> <?= htmlspecialchars($info['Total'] ?? '-') ?></p>
            <form method="post" action="update_status.php" class="status-form">
              <input type="hidden" name="order_id" value="<?= $order_id ?>">
              <select name="new_status">
                <option <?= $info['Status'] === 'В обработке' ? 'selected' : '' ?>>В обработке</option>
                <option <?= $info['Status'] === 'Оформлен' ? 'selected' : '' ?>>Оформлен</option>
                <option <?= $info['Status'] === 'Доставка' ? 'selected' : '' ?>>Доставка</option>
                <option <?= $info['Status'] === 'Завершен' ? 'selected' : '' ?>>Завершен</option>
              </select>
              <button type="submit">Изменить статус</button>
            </form>
            <form method="post" action="delete_order.php" class="delete-form" onsubmit="return confirm('Удалить заказ?');">
              <input type="hidden" name="order_id" value="<?= $order_id ?>">
              <button type="submit">Удалить заказ</button>
            </form>
          </div>
        <?php endforeach;
    }
}
?>
</div>
<?php include('../includes/footer.php'); ?>
</body>
</html>