# Практическая работа 6: REST API на PHP

API находится в папке `api` и возвращает ответы в формате JSON.

## Запуск

Папку проекта нужно открыть через локальный сервер с PHP, например XAMPP или OpenServer.

Пример базового адреса:

```text
http://localhost/praktika.html/api/v1
```

Если переписывание URL через `.htaccess` не работает, можно обращаться так:

```text
http://localhost/praktika.html/api/index.php/v1/users
```

## Endpoints

```text
POST   /api/v1/register
POST   /api/v1/login
GET    /api/v1/users
GET    /api/v1/users/{id}
PUT    /api/v1/users/{id}
PATCH  /api/v1/users/{id}
DELETE /api/v1/users/{id}
```

## Тестовые пользователи

```text
admin@test.com / admin123
user@test.com / user123
```

## Примеры cURL

```bash
curl -X POST http://localhost/praktika.html/api/v1/register -H "Content-Type: application/json" -d "{\"name\":\"Nikita\",\"email\":\"nikita@test.com\",\"password\":\"123456\"}"

curl -X POST http://localhost/praktika.html/api/v1/login -H "Content-Type: application/json" -d "{\"email\":\"admin@test.com\",\"password\":\"admin123\"}"

curl http://localhost/praktika.html/api/v1/users

curl http://localhost/praktika.html/api/v1/users/1

curl -X PATCH http://localhost/praktika.html/api/v1/users/1 -H "Content-Type: application/json" -d "{\"password\":\"newpass123\"}"

curl -X DELETE http://localhost/praktika.html/api/v1/users/2
```