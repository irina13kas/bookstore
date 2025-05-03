<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>О нас — В гостях у бабушки Кристи</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../styles/style.css">
</head>
<body>

<?php include('../includes/header.php'); ?>
<?php include('../includes/select_books.php'); ?>
  <main class="about-page">

    <section class="intro reveal">
      <div class="container">
        <h2>Почему мы создали этот магазин</h2>
        <p>Мы — настоящие поклонники творчества Агаты Кристи. Её детективы вдохновляют нас на размышления, погружают в атмосферу таинственности и британского шарма. Мы мечтали создать уютное пространство для таких же любителей загадок и классических сюжетов, как и мы. Именно так родился наш магазин "В гостях у бабушки Кристи" — место, где каждая книга ждёт своего читателя.</p>
      </div>
    </section>

    <section class="contact-section reveal">
      <div class="container contact-flex">
      <div class="contact-image">
          <img src="/assets/images/bookstore.jpg" alt="Наш магазин">
        </div>
        <div class="contact-info">
          <h2>Контактная информация</h2>
          <p><strong>Адрес:</strong> г. Санкт-Петербург, ул. Тумановская, д. 7</p>
          <p><strong>Телефон:</strong> +7 (812) 123-45-67</p>
          <p><strong>Режим работы:</strong> Пн–Вс, 10:00–20:00</p>
        </div>
      </div>
    </section>

    <section class="goodbye-message reveal">
      <div class="container">
        <h3>Ждём вас с нетерпением!</h3>
      </div>
    </section>

  </main>

  <?php include('../includes/footer.php'); ?>

  <script>
    const reveals = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('active');
        }
      });
    }, { threshold: 0.1 });

    reveals.forEach(el => observer.observe(el));
  </script>

</body>
</html>
