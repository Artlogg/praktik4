<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?error=auth_required');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Личный кабинет - Мой сайт книг</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <ul class="menu">
    <li><a class="menu-link" href="index.html">Главная</a></li>
    <li><a class="menu-link" href="catalog.html">Каталог</a></li>
    <li><a class="menu-link" href="dashboard.php">Кабинет</a></li>
    <li><a class="menu-link" href="logout.php">Выход</a></li>
  </ul>
  <hr>

  <h1>Личный кабинет</h1>

  <div class="dashboard-box">
    <p>Вы вошли как: <strong><?php echo htmlspecialchars($_SESSION['name']); ?></strong></p>
    <p>Логин: <strong><?php echo htmlspecialchars($_SESSION['login']); ?></strong></p>
    <p>ID пользователя: <strong><?php echo (int) $_SESSION['user_id']; ?></strong></p>
    <p><a class="menu-link" href="catalog.html">Перейти в каталог книг</a></p>
    <p><a class="logout-link" href="logout.php">Выйти из системы</a></p>
  </div>

  <hr>
  <p>&copy; Все права защищены</p>
</body>
</html>