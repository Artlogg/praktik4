<?php
require __DIR__ . '/../models/User.php';

function jsonInput(): array
{
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);

    return is_array($data) ? $data : [];
}

function jsonResponse(string $status, string $message, int $code = 200, array $data = []): void
{
    http_response_code($code);
    echo json_encode([
        'status' => $status,
        'message' => $message,
        'data' => $data,
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

class UserController
{
    private User $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function register(): void
    {
        $data = jsonInput();
        $name = trim($data['name'] ?? '');
        $email = trim($data['email'] ?? '');
        $password = (string) ($data['password'] ?? '');

        if ($name === '' || $email === '' || $password === '') {
            jsonResponse('error', 'Заполните name, email и password', 400);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            jsonResponse('error', 'Некорректный email', 400);
            return;
        }

        if (mb_strlen($password) < 6) {
            jsonResponse('error', 'Пароль должен быть не короче 6 символов', 400);
            return;
        }

        if ($this->model->findByEmail($email) !== null) {
            jsonResponse('error', 'Пользователь с таким email уже существует', 409);
            return;
        }

        $user = $this->model->create($name, $email, $password);
        jsonResponse('success', 'Пользователь зарегистрирован', 201, ['user' => $user]);
    }

    public function login(): void
    {
        $data = jsonInput();
        $email = trim($data['email'] ?? '');
        $password = (string) ($data['password'] ?? '');

        if ($email === '' || $password === '') {
            jsonResponse('error', 'Заполните email и password', 400);
            return;
        }

        $user = $this->model->findByEmail($email);

        if ($user === null) {
            jsonResponse('error', 'Пользователь не найден', 404);
            return;
        }

        if (!password_verify($password, $user['password_hash'])) {
            jsonResponse('error', 'Неверный пароль', 401);
            return;
        }

        unset($user['password_hash']);
        jsonResponse('success', 'Авторизация успешна', 200, ['user' => $user]);
    }

    public function getUsers(): void
    {
        jsonResponse('success', 'Список пользователей получен', 200, [
            'users' => $this->model->allPublic(),
        ]);
    }

    public function getUser(int $id): void
    {
        $user = $this->model->findById($id);

        if ($user === null) {
            jsonResponse('error', 'Пользователь не найден', 404);
            return;
        }

        unset($user['password_hash']);
        jsonResponse('success', 'Пользователь найден', 200, ['user' => $user]);
    }

    public function updatePassword(int $id): void
    {
        $data = jsonInput();
        $password = (string) ($data['password'] ?? $data['new_password'] ?? '');

        if ($password === '') {
            jsonResponse('error', 'Передайте новый пароль', 400);
            return;
        }

        if (mb_strlen($password) < 6) {
            jsonResponse('error', 'Пароль должен быть не короче 6 символов', 400);
            return;
        }

        $user = $this->model->updatePassword($id, $password);

        if ($user === null) {
            jsonResponse('error', 'Пользователь не найден', 404);
            return;
        }

        jsonResponse('success', 'Пароль пользователя обновлен', 200, ['user' => $user]);
    }

    public function deleteUser(int $id): void
    {
        if (!$this->model->delete($id)) {
            jsonResponse('error', 'Пользователь не найден', 404);
            return;
        }

        jsonResponse('success', 'Пользователь удален', 200, ['id' => $id]);
    }
}