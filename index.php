<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>В гостях у бабушки Кристи</title>
  <link rel="stylesheet" href="/styles/style.css">
</head>
<body>

<?php include('includes/header.php'); ?>
<?php include('includes/authorization_form.php'); ?>
<main class="author-page">

<section class="section reveal">
  <div class="content">
  <img src="/assets/images/childhood.jpg" alt="Агата Кристи в детстве">
    <div class="text">
      <h2>Детство</h2>
      <p>Агата Мэри Кларисса Миллер родилась в 1890 году в Торки, Великобритания. Её семья была интеллигентной и обеспеченной, и детство Агаты прошло в уединённой, но вдохновляющей обстановке. Её мама поощряла фантазию дочери, позволяя ей придумывать сказки и читать с самых ранних лет. Уже в 5 лет она сочиняла стихи и рассказы, а в 11 — впервые задумалась о романе.</p>
    </div>
  </div>
</section>

<section class="section reveal">
  <div class="content">
    <div class="text">
      <h2>Писательская карьера</h2>
      <p>В годы Первой мировой войны Агата работала медсестрой и ассистентом фармацевта, что дало ей глубокие знания в области ядов. Это отразилось в её первых детективах. В 1920 году публикуется её первый роман — «Таинственное происшествие в Стайлзе», с которым мир познакомился с Эркюлем Пуаро. Это стало началом её великой карьеры длиною в 50 лет.</p>
    </div>
    <img src="/assets/images/youth.jpg" alt="Писательская карьера">
  </div>
</section>

<section class="section reveal">
  <div class="content">
  <img src="/assets/images/main_photo.jpg" alt="Агата Кристи - мировая слава">
    <div class="text">
      <h2>Мировая слава</h2>
      <p>Кристи стала настоящим феноменом. Её книги переведены более чем на 100 языков. Общий тираж превысил 2 миллиарда экземпляров. Театральная постановка «Мышеловка» считается самой продолжительной в истории. Её имя стоит рядом с Библией и Шекспиром по продажам. Она также была удостоена титула Дамы от королевы Елизаветы II в 1971 году.</p>
    </div>
  </div>
</section>

<section class="section reveal">
  <div class="content">
    <div class="text">
      <h2>Личная жизнь</h2>
      <p>Агата была дважды замужем. После первого неудачного брака она вышла за археолога Макса Маллоуэна. Вместе они исследовали страны Ближнего Востока. Эти поездки вдохновили её на создание таких произведений, как «Убийство в Месопотамии» и «Смерть на Ниле». Несмотря на славу, Кристи оставалась скромной женщиной, предпочитавшей покой своему дому в Девоне.</p>
    </div>
    <img src="/assets/images/second_husband.jpg" alt="Личная жизнь">
  </div>
</section>
</main>
<?php include('includes/footer.php'); ?>
<script>
// Плавное появление блоков
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