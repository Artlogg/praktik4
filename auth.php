<?php
session_start();

require __DIR__ . '/users.php';
require __DIR__ . '/logger.php';

$login = trim($_POST['login'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($login === '' || $password === '') {
    writeAuthLog($login, 'FAIL_LOGIN', 'empty_fields');
    header('Location: login.php?error=empty');
    exit;
}

if (!isset($users[$login])) {
    writeAuthLog($login, 'FAIL_LOGIN', 'user_not_found');
    header('Location: login.php?error=invalid');
    exit;
}

$user = $users[$login];

if (!password_verify($password, $user['password_hash'])) {
    writeAuthLog($login, 'FAIL_LOGIN', 'wrong_password');
    header('Location: login.php?error=invalid');
    exit;
}

session_regenerate_id(true);
$_SESSION['user_id'] = $user['id'];
$_SESSION['login'] = $login;
$_SESSION['name'] = $user['name'];

writeAuthLog($login, 'SUCCESS_LOGIN');

header('Location: dashboard.php');
exit;