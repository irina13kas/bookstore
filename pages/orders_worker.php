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
<?php
require_once '../includes/connect_db.php';
$status = $_GET['status'] ?? 'В обработке';
$stmt = $pdo->prepare("CALL get_orders_by_status(?)");
$stmt->execute([$status]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Заказы: <?= htmlspecialchars($status) ?></h2>
<a href="../includes/new_order_select_books.php" class="new-order-btn">Оформить новый заказ</a>
<form method="get" class="form-order-worker">
<select class="select-order-worker" name="status" onchange="this.form.submit()">
    <option value="all">Все</option>
    <option value="В обработке">В обработке</option>
    <option value="Оформлен">Оформлен</option>
    <option value="Доставка">Доставка</option>
    <option value="Завершен">Завершен</option>
  </select>
</form>

<?php
if (count($orders) === 0) {
    echo "<p>Нет заказов</p>";
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
                    <input type="hidden" name="order_id" value="<?= $order['Id'] ?>">
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
<?php endforeach; } ?>
</div>
<?php include('../includes/footer.php'); ?>
</body>
</html>