<?php 
session_start();
include "../includes/add_to_cart_worker.php";
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
  <title>О нас — В гостях у бабушки Кристи</title>
  <link rel="icon" href="/assets/images/icon.ico" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../styles/style.css">
</head>
<?php include('../includes/header.php'); ?>
<?php include('../includes/authorization_form.php'); ?>
<body>
<div class="container">
  <form method="POST">
    <fieldset>
      <legend>Название книги:</legend>
      <input type="text" name="Title" placeholder="Введите название книги" value="<?= htmlspecialchars($_POST['Title'] ?? '') ?>">
      <button type="submit" name="search">Поиск</button>
    </fieldset>
  </form>

<?php include "filter_title.php"; ?>
<?php if ($books):
    echo '<table class="book-table">';
    echo '<tr><th>Название</th><th>Год</th><th>Страниц</th><th>Язык</th><th>Издатель</th><th>Обложка</th><th>Цена</th><th>Кол-во</th><th>Действие</th></tr>';
    foreach ($books as $book):
      $bookId = $book['BookId'];
      $isInCart = isset($_SESSION['cart'][$bookId]);
      $savedQty = $isInCart ? $_SESSION['cart'][$bookId]['qty'] : 1;
      $rowClass = $isInCart ? 'highlighted' : '';
?>
<tr class="<?= $rowClass ?>">
  <td><?= htmlspecialchars($book['BookTitle']) ?></td>
  <td><?= $book['BookYear'] ?></td>
  <td><?= $book['Pages'] ?></td>
  <td><?= $book['Language'] ?></td>
  <td><?= $book['Publisher'] ?></td>
  <td><?= $book['Cover'] ?></td>
  <td><?= $book['Price'] ?> ₽</td>
  <td>
    <form method="post" style="display: flex; gap: 5px;">
      <input type="hidden" name="book_id" value="<?= $book['BookId'] ?>">
      <input type="hidden" name="title" value="<?= htmlspecialchars($book['BookTitle']) ?>">
        <input type="hidden" name="price" value="<?= htmlspecialchars($book['Price']) ?>">
        <input type="hidden" name="max_qty" value="<?= htmlspecialchars($book['Instances']) ?>">
        <input type="number" name="qty" min="1" max="<?= $book['Instances'] ?>" value="<?= $savedQty ?>" style="width: 60px;">
    
  </td>
  <td>
  <button type="submit" name="add_to_order">Добавить</button>
  </td>
  </form>
</tr>
<?php
    endforeach;
    echo '</table>';
else:
    echo '<p>Книги не найдены.</p>';
endif;
?>
  <form method="POST" action="../pages/orders_worker.php">
    <button type="submit" class="btn-next">Отмена</button>
  </form>
<?php if (!empty($_SESSION['cart'])): ?>
  <form method="POST" action="../includes/offline_order_checkout.php">
    <button type="submit" class="btn-next">Далее</button>
  </form>
<?php endif; ?>
</div>
<?php include('../includes/footer.php'); ?>
</body>
</html>
