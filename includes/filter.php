<?php
require_once '../includes/connect_db.php';
include "../includes/get_all_books.php";
$query = $pdo->prepare("SELECT DISTINCT Country FROM view_countries_cities");
$query->execute();
$countries = $query->fetchAll(PDO::FETCH_ASSOC);
$query = $pdo->prepare("SELECT DISTINCT City FROM view_countries_cities");
$query->execute();
$cities = $query->fetchAll(PDO::FETCH_ASSOC);
$query = $pdo->prepare("SELECT Lang FROM view_languages");
$query->execute();
$languages =  $query->fetchAll(PDO::FETCH_ASSOC);
$query = $pdo->prepare("SELECT Name FROM view_publishers");
$query->execute();
$publishers = $query->fetchAll(PDO::FETCH_ASSOC);
$query = $pdo->prepare("SELECT Name FROM view_detectives");
$query->execute();
$detectives = $query->fetchAll(PDO::FETCH_ASSOC);
$query = $pdo->prepare("SELECT `Method` FROM view_methods_of_killing");
$query->execute();
$methods_of_killing = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<form method="POST" class="filter-form">
  <input type="text" name="search" placeholder="Поиск по названию" value="<?= htmlspecialchars($_POST['search'] ?? '') ?>">

  <details>
    <summary>Фильтры</summary>

    <label>Страна:
  <select name="country">
    <option value="">Любая</option>
    <?php foreach ($countries as $country): ?>
      <option value="<?= $country['Country'] ?>" 
        <?= isset($_POST['country']) && $_POST['country'] === $country['Country'] ? 'selected' : '' ?>>
        <?= $country['Country'] ?>
      </option>
    <?php endforeach; ?>
  </select>
</label>

<label>Город:
  <select name="city">
    <option value="">Любой</option>
    <?php foreach ($cities as $city): ?>
      <option value="<?= $city['City'] ?>" 
        <?= isset($_POST['city']) && $_POST['city'] === $city['City'] ? 'selected' : '' ?>>
        <?= $city['City'] ?>
      </option>
    <?php endforeach; ?>
  </select>
</label>

<label>Язык:
  <select name="language">
    <option value="">Любой</option>
    <?php foreach ($languages as $lang): ?>
      <option value="<?= $lang['Lang'] ?>" 
        <?= isset($_POST['language']) && $_POST['language'] === $lang['Lang'] ? 'selected' : '' ?>>
        <?= $lang['Lang'] ?>
      </option>
    <?php endforeach; ?>
  </select>
</label>

<fieldset>
  <legend>Издательства:</legend>
  <?php foreach ($publishers as $pub): ?>
    <label>
      <input type="checkbox" name="publisher[]" value="<?= $pub['Name'] ?>" 
        <?= isset($_POST['publisher']) && in_array($pub['Name'], $_POST['publisher']) ? 'checked' : '' ?>>
      <?= $pub['Name'] ?>
    </label>
  <?php endforeach; ?>
</fieldset>

<fieldset>
  <legend>Детектив:</legend>
  <?php foreach ($detectives as $det): ?>
    <label>
      <input type="checkbox" name="detective[]" value="<?= $det['Name'] ?>" 
        <?= isset($_POST['detective']) && in_array($det['Name'], $_POST['detective']) ? 'checked' : '' ?>>
      <?= $det['Name'] ?>
    </label>
  <?php endforeach; ?>
</fieldset>

<fieldset>
  <legend>Герой:</legend>
  <input type="text" name="heroName" placeholder="Введите имя героя" value="<?= htmlspecialchars($_POST['heroName'] ?? '') ?>">
</fieldset>


<fieldset>
  <legend>Способ совершения убийства:</legend>
  <?php foreach ($methods_of_killing as $met): ?>
    <label>
      <input type="radio" name="method" value="<?= $met['Method'] ?>" 
        <?= isset($_POST['method']) && $_POST['method'] === $met['Method'] ? 'checked' : '' ?>>
      <?= $met['Method'] ?>
    </label>
  <?php endforeach; ?>
  <label>
    <input type="radio" name="method" value="" 
      <?= empty($_POST['method']) ? 'checked' : '' ?>>
    Любой
  </label>
</fieldset>

    <button type="submit" name="apply_button">Применить</button>
  </details>
</form>
