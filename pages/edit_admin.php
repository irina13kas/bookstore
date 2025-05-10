<?php
session_start();

if ($_COOKIE['user_role'] !== 'Admin') {
    header('Location: ../index.php');
    exit;
}

// Загрузка данных
include "../includes/data_for_new_book.php";
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
  <div class="container">
<h2>Управление книгами</h2>


  <div class="tool-buttons">
    <button data-target="form-add" class="tool-btn">Внести</button>
    <button data-target="form-delete" class="tool-btn" >Удалить</button>
  </div>
  <?php if ($books):
    echo '<table class="book-table">';
    echo '<tr><th>Название</th><th>Год</th><th>Страниц</th><th>Язык</th><th>Издатель</th><th>Обложка</th><th>Цена</th><th>Кол-во</th><th>Действие</th></tr>';
    foreach ($books as $book):
?>
<tr class="<?= $rowClass ?>">
  <td><?= htmlspecialchars($book['BookTitle']) ?></td>
  <td><?= $book['BookYear'] ?></td>
  <td><?= $book['Pages'] ?></td>
  <td><?= $book['Language'] ?></td>
  <td><?= $book['Publisher'] ?></td>
  <td><?= $book['Cover'] ?></td>
  <td><?= $book['Price'] ?> ₽</td>
  <td><?= $book['Instances'] ?></td>
  <td>
<form method="post" action="../includes/update_book.php">
    <input type="hidden" name="id" value="<?= $book['BookId'] ?>">
    <input type="hidden" name="book_id" value="<?= $book['BookTitle'] ?>">
    <input type="hidden" name="year" value="<?= $book['BookYear'] ?>">
    <input type="hidden" name="pages" value="<?= $book['Pages'] ?>">
    <input type="hidden" name="lang_id" value="<?= $book['Language'] ?>">
    <input type="hidden" name="publisher_id" value="<?= $book['Publisher'] ?>">
    <input type="hidden" name="cover" value="<?= $book['Cover'] ?>">
    <input type="hidden" name="price" value="<?= $book['Price'] ?>">
    <input type="hidden" name="qty" value="<?= $book['Instances'] ?>">
    <button type="submit" >Редактировать</button>
</form>
  </td>
</tr>
<?php
    endforeach;
    echo '</table>';
else:
    echo '<p>Книги не найдены.</p>';
endif;
?>
<?php include "../includes/add_new_book.php"; ?>
</div>
<?php include('../includes/footer.php'); ?>
<script>
   const toolButtons = document.querySelectorAll('.tool-btn');
  const bookAdd = document.getElementById('form-add');
  const bookTable = document.querySelector('.book-table');

  toolButtons.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();

      toolButtons.forEach(b => b.classList.remove('active'));

      btn.classList.add('active');

      if (btn.dataset.target === 'form-add') {
        bookAdd.classList.remove('hidden');
        if (bookTable) bookTable.style.display = 'none';
      }
    });
  });
</script>
</body>

</html>