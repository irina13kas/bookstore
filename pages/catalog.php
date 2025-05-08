<?php
session_start();
unset($_SESSION['cart']);
include "../includes/add_to_cart.php";
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
<?php include('../includes/header.php');?>
 <?php include('../includes/authorization_form.php'); ?>
 <?php include('../includes/select_books.php'); ?>
<main class="catalog-page">
  <div class="container">
    <h2>Каталог книг</h2>
    <div class="catalog-container" onclick="showDetails(this)">
      <?php foreach ($books as $book): ?>
        <div class="book-card"
             data-title="<?= htmlspecialchars($book['BookTitle']) ?>"
             data-price="<?= $book['Price'] ?>"
             data-description="<?= htmlspecialchars($book['Description']) ?>"
             data-year="<?= $book['BookYear'] ?>"
             data-publisher="<?= htmlspecialchars($book['Publisher']) ?>"
             data-detective="<?= htmlspecialchars($book['Detective']) ?>"
             data-language="<?= htmlspecialchars($book['Language']) ?>">
          <h3><?= htmlspecialchars($book['BookTitle']) ?></h3>
          <p class="price"><?= $book['Price'] ?> ₽</p>
          <form method="post">
          <input type="hidden" name="title" value="<?= htmlspecialchars($book['BookTitle']) ?>">
          <input type="hidden" name="price" value="<?= htmlspecialchars($book['Price']) ?>">
          <input type="hidden" name="book_id" value="<?= htmlspecialchars($book['BookId']) ?>">
          <input type="hidden" name="max_qty" value="<?= htmlspecialchars($book['Instances']) ?>">
          <label>
            Кол-во: 
            <input type="number" name="qty" min="1" max="<?= $book['Instances'] ?>" value="1" onclick="event.stopPropagation()" onkeydown="event.stopPropagation()">
            </label><br>

            <button type="submit" name="add_to_cart_button" onclick="event.stopPropagation()">Добавить в корзину</button>
            </form>
        </div>
      <?php endforeach; ?>
    </div>

<div class="modal" id="modal">
  <div class="modal-content">
    <span class="close" onclick="hideModal()">✖</span>
    <h3 id="modalTitle"></h3>
    <p><strong>Описание:</strong> <span id="modalDesc"></span></p>
    <p><strong>Год издания:</strong> <span id="modalYear"></span></p>
    <p><strong>Издательство:</strong> <span id="modalPublisher"></span></p>
    <p><strong>Детектив:</strong> <span id="modalDetective"></span></p>
    <p><strong>Язык:</strong> <span id="modalLang"></span></p>
    <p><strong>Цена:</strong> <span id="modalPrice"></span> ₽</p>
  </div>
</div>
</form>
  </div>
</main>

<?php include('../includes/footer.php'); ?>

<script>
function showDetails(card) {
var card = event.target.closest('.book-card');
  document.getElementById('modalTitle').innerText = card.getAttribute('data-title');
  document.getElementById('modalDesc').innerText = card.getAttribute('data-description');
  document.getElementById('modalYear').innerText = card.getAttribute('data-year');
  document.getElementById('modalPublisher').innerText = card.getAttribute('data-publisher');
  document.getElementById('modalDetective').innerText = card.getAttribute('data-detective');
  document.getElementById('modalPrice').innerText = card.getAttribute('data-price');
  document.getElementById('modalLang').innerText = card.getAttribute('data-language');
  document.getElementById('modal').style.display = 'flex';
}

function hideModal() {
  document.getElementById('modal').style.display = 'none';
}
</script>


</body>
</html>