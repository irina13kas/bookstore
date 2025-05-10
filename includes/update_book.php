<?php 
if ($_COOKIE['user_role'] !== 'Admin') {
    header('Location: ../index.php');
    exit;
}

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
  <div class="container"></div>
<div id="form-edit" class="book-form">
  <h3>Изменить книгу</h3>
  <form method="POST" action="../includes/submit_edit_book.php">
    <label>Название книги:</label>
    <select name="book_id" required>
      <option value="">Выберите</option>
      <?php foreach ($abstract_books as $ab): ?>
        <option value="<?= $ab['Id'] ?>" <?= ($_POST['book_id'] === $ab['Title']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($ab['Title']) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <label>Год публикации:</label>
    <input type="number" name="year" min="1921" max="<?= date('Y') + 1 ?>" required
           value="<?= $_POST['year'] ?? '' ?>">

    <label>Кол-во страниц:</label>
    <input type="number" name="pages" min="1" max="999" required
           value="<?= $_POST['pages'] ?? '' ?>">

    <label>Кол-во экземпляров:</label>
    <input type="number" name="qty" min="1" required
           value="<?= $_POST['qty'] ?? '' ?>">

    <label>Цена (₽):</label>
    <input type="number" name="price" min="1" required
           value="<?= $_POST['price'] ?? '' ?>">

    <label>Язык перевода:</label>
    <select name="lang_id" required>
      <option value="">Выберите</option>
      <?php foreach ($languages as $lang): ?>
        <option value="<?= $lang['Id'] ?>" <?= (isset($_POST['lang_id']) && $_POST['lang_id'] == $lang['Lang']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($lang['Lang']) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <label>Обложка:</label>
    <select name="cover" required>
      <option value="">Выберите</option>
      <?php foreach ($covers as $c): ?>
        <option value="<?= $c ?>" <?= (isset($_POST['cover']) && $_POST['cover'] == $c) ? 'selected' : '' ?>>
          <?= $c ?>
        </option>
      <?php endforeach; ?>
    </select>

    <label>Издательство:</label>
    <select name="publisher_id" required>
      <option value="">Выберите</option>
      <?php foreach ($publishers as $pub): ?>
        <option value="<?= $pub['Id'] ?>" <?= (isset($_POST['publisher_id']) && $_POST['publisher_id'] == $pub['Name']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($pub['Name']) ?>
        </option>
      <?php endforeach; ?>
    </select>
    <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
    <button type="submit">Изменить</button>
  </form>
</div>
</div>
<?php include('../includes/footer.php'); ?>
</body>

</html>


<?php
// session_start();
// if (isset($_POST['update_stock'])) {
//     require_once '../includes/connect_db.php';
//     $id = $_POST['book_id'];
//     $inc = $_POST['increase'];
//     $stmt = $pdo->prepare("CALL increase_book_stock(?, ?)");
//     $stmt->execute([$id, $inc]);
// }
//     header("Location: ../pages/edit_admit.php");
//     exit;
 ?>