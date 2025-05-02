<?php
session_start();
require_once 'includes/db.php'; // подключение к БД через PDO
include 'includes/header.php';

// Подгружаем книги
$stmt = $pdo->prepare("
    SELECT 
        b.Id,
        b.Title AS BookTitle,
        b.Price,
        b.Instances,
        b.Year_of_publishing AS BookYear,
        b.Publisher,
        ab.Description,
        ab.Detective,
        ab.Year_of_publishing AS OriginalYear
    FROM book b
    JOIN abstract_book ab ON b.Code = ab.Id
");
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="catalog-page">
  <div class="container">
    <h2>Каталог книг</h2>
    <div class="catalog-container">
      <?php foreach ($books as $book): ?>
        <div class="book-card" onclick="showDetails(this)" 
             data-title="<?= htmlspecialchars($book['BookTitle']) ?>"
             data-price="<?= $book['Price'] ?>"
             data-description="<?= htmlspecialchars($book['Description']) ?>"
             data-year="<?= $book['BookYear'] ?>"
             data-publisher="<?= htmlspecialchars($book['Publisher']) ?>"
             data-detective="<?= htmlspecialchars($book['Detective']) ?>">
          <h3><?= htmlspecialchars($book['BookTitle']) ?></h3>
          <p class="price"><?= $book['Price'] ?> ₽</p>
          <label>Количество: <input type="number" name="qty" min="1" value="1"></label><br>
          <button>Добавить в корзину</button>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="book-details" id="bookDetails" style="display: none;">
      <h3 id="detailTitle"></h3>
      <p><strong>Описание:</strong> <span id="detailDesc"></span></p>
      <p><strong>Год издания:</strong> <span id="detailYear"></span></p>
      <p><strong>Издательство:</strong> <span id="detailPublisher"></span></p>
      <p><strong>Детектив:</strong> <span id="detailDetective"></span></p>
      <p><strong>Цена:</strong> <span id="detailPrice"></span> ₽</p>
      <button onclick="hideDetails()">Закрыть</button>
    </div>
  </div>
</main>

<?php include 'includes/footer.php'; ?>

<script>
function showDetails(card) {
  document.getElementById('bookDetails').style.display = 'block';
  document.getElementById('detailTitle').innerText = card.dataset.title;
  document.getElementById('detailDesc').innerText = card.dataset.description;
  document.getElementById('detailYear').innerText = card.dataset.year;
  document.getElementById('detailPublisher').innerText = card.dataset.publisher;
  document.getElementById('detailDetective').innerText = card.dataset.detective;
  document.getElementById('detailPrice').innerText = card.dataset.price;
}

function hideDetails() {
  document.getElementById('bookDetails').style.display = 'none';
}
</script>
