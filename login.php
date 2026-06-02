<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = $_GET['error'] ?? '';
$message = $_GET['message'] ?? '';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Авторизация - Мой сайт книг</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <ul class="menu">
    <li><a class="menu-link" href="index.html">Главная</a></li>
    <li><a class="menu-link" href="catalog.html">Каталог</a></li>
    <li><a class="menu-link" href="login.php">Вход</a></li>
  </ul>
  <hr>

  <h1>Авторизация</h1>

  <?php if ($error === 'empty'): ?>
    <p class="error-message">Заполните логин и пароль.</p>
  <?php elseif ($error === 'invalid'): ?>
    <p class="error-message">Неверный логин или пароль.</p>
  <?php elseif ($error === 'auth_required'): ?>
    <p class="error-message">Для доступа к личному кабинету необходимо войти.</p>
  <?php endif; ?>

  <?php if ($message === 'logout'): ?>
    <p class="success-message">Вы вышли из системы.</p>
  <?php endif; ?>

  <form class="auth-form" action="auth.php" method="post">
    <label for="login">Логин:</label>
    <input type="text" id="login" name="login" required>

    <label for="password">Пароль:</label>
    <input type="password" id="password" name="password" required minlength="4">

    <button type="submit">Войти</button>
  </form>

  <div class="auth-hint">
    <p>Тестовые пользователи:</p>
    <p>admin / admin123</p>
    <p>user / user123</p>
  </div>

  <hr>
  <p>&copy; Все права защищены</p>
</body>
</html>