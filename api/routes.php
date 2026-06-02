<?php
require __DIR__ . '/controllers/UserController.php';

function getApiPath(): string
{
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
    $path = preg_replace('#^.*?/api#', '', $path);
    $path = str_replace('/index.php', '', $path);
    $path = '/' . trim($path, '/');

    return $path === '/' ? '/v1' : $path;
}

function handleRequest(): void
{
    $method = $_SERVER['REQUEST_METHOD'];
    $path = getApiPath();
    $controller = new UserController();

    if ($method === 'POST' && $path === '/v1/register') {
        $controller->register();
        return;
    }

    if ($method === 'POST' && $path === '/v1/login') {
        $controller->login();
        return;
    }

    if ($method === 'GET' && $path === '/v1/users') {
        $controller->getUsers();
        return;
    }

    if (preg_match('#^/v1/users/(\d+)$#', $path, $matches)) {
        $id = (int) $matches[1];

        if ($method === 'GET') {
            $controller->getUser($id);
            return;
        }

        if ($method === 'PUT' || $method === 'PATCH') {
            $controller->updatePassword($id);
            return;
        }

        if ($method === 'DELETE') {
            $controller->deleteUser($id);
            return;
        }
    }

    jsonResponse('error', 'Маршрут не найден', 404, [
        'method' => $method,
        'path' => $path,
    ]);
}