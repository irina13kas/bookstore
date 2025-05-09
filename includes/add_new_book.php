<?php 
session_start();
?>
<div id="form-add" class="book-form hidden">
  <h3>Добавить новую книгу</h3>
  <form method="POST" action="../includes/submit_new_book.php">
    <label>Название книги:</label>
    <select name="book_id" required>
      <option value="">Выберите</option>
      <?php foreach ($abstract_books as $ab): ?>
        <option value="<?= $ab['Id'] ?>"><?= htmlspecialchars($ab['Title']) ?></option>
      <?php endforeach; ?>
    </select>

    <label>Год публикации:</label>
    <input type="number" name="year" min="1921" max="<?= date('Y') + 1 ?>" required>

    <label>Кол-во страниц:</label>
    <input type="number" name="pages" min="1" max="999" required>

    <label>Кол-во экземпляров:</label>
    <input type="number" name="qty" min="1" required>

    <label>Цена (₽):</label>
    <input type="number" name="price" min="1" required>

    <label>Язык перевода:</label>
    <select name="lang_id" required>
      <option value="">Выберите</option>
      <?php foreach ($languages as $lang): ?>
        <option value="<?= $lang['Id'] ?>"><?= htmlspecialchars($lang['Lang']) ?></option>
      <?php endforeach; ?>
    </select>

    <label>Обложка:</label>
    <select name="cover" required>
      <option value="">Выберите</option>
      <?php foreach ($covers as $c): ?>
        <option value="<?= $c ?>"><?= $c ?></option>
      <?php endforeach; ?>
    </select>

    <label>Издательство:</label>
    <select name="publisher_id" required>
      <option value="">Выберите</option>
      <?php foreach ($publishers as $pub): ?>
        <option value="<?= $pub['Id'] ?>"><?= htmlspecialchars($pub['Name']) ?></option>
      <?php endforeach; ?>
    </select>

    <button type="submit">Добавить</button>
  </form>
</div>