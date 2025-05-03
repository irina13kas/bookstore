<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>В гостях у бабушки Кристи</title>
  <link rel="stylesheet" href="/styles/style.css">
</head>

<div id="auth-form" class="auth-popup" style="display: none;">
  <form method="POST" action="../includes/login.php">
  <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
    <input type="text" name="login" placeholder="Логин" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit">Войти</button>
  </form>
</div>

<script>
  document.getElementById('auth-btn').addEventListener('click', function () {
  const isLoggedIn = this.textContent === 'Вы в системе';

  if (isLoggedIn) {
    if (confirm('Вы уверены, что хотите выйти из системы?')) {
      window.location.href = '../includes/logout.php';
    }
  } else {
    document.getElementById('auth-form').style.display = 'block';
  }
});
  const authForm = document.getElementById('auth-form');

  document.addEventListener('click', (e) => {
    if (!authForm.contains(e.target) && e.target !== authBtn) {
      authForm.style.display = 'none';
    }
  });
</script>
