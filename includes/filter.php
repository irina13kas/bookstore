<?php
require_once '../includes/connect_db.php';

$stmt = $pdo->prepare("SELECT * FROM view_catalog");
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
?>

<form method="POST" class="filter-form">
  <input type="text" name="search" placeholder="Поиск по названию" value="<?= htmlspecialchars($_POST['search'] ?? '') ?>">

  <details>
    <summary>Фильтры</summary>

    <label>Страна:
      <select name="country">
        <option value="">Любая</option>
        <?php foreach ($countries as $country): ?>
            <option value="<?= $country['Country'] ?>"><?= $country['Country'] ?></option>
        <?php endforeach; ?>
      </select>
    </label>

    <label>Город:
      <select name="city">
        <option value="">Любой</option>
        <?php foreach ($cities as $city): ?>
            <option value="<?= $city['City'] ?>"><?= $city['City'] ?></option>
        <?php endforeach; ?>
      </select>
    </label>

    <label>Язык:
      <select name="language">
        <option value="" >Любой</option>
        <?php foreach ($languages as $lang): ?>
            <option value="<?= $lang['Lang'] ?>"><?= $lang['Lang'] ?></option>
        <?php endforeach; ?>
      </select>
    </label>

    <fieldset>
      <legend>Издательства:</legend>
      <?php foreach ($publishers as $pub): ?>
        <label><input type="checkbox" name="publisher[]" value="<?= $pub['Name'] ?>"> <?= $pub['Name'] ?></label>
      <?php endforeach; ?>
    </fieldset>

    <fieldset>
      <legend>Детектив:</legend>
      <?php foreach ($detectives as $det): ?>
        <label><input type="checkbox" name="detective[]" value="<?= $det['Name'] ?>"> <?= $det['Name'] ?></label>
      <?php endforeach; ?>
    </fieldset>

    <fieldset>
  <legend>Герой:</legend>
  <input type="text" name="heroName" placeholder="Введите имя героя" value="<?= htmlspecialchars($_POST['heroName'] ?? '') ?>">
</fieldset>

    <button type="submit" name="apply_button">Применить</button>
  </details>
</form>
