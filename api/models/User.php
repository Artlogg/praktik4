<?php
class User
{
    private string $file;

    public function __construct()
    {
        $this->file = __DIR__ . '/../data/users.json';
        $this->ensureDataFile();
    }

    public function all(): array
    {
        $content = file_get_contents($this->file);
        $users = json_decode($content, true);

        return is_array($users) ? $users : [];
    }

    public function allPublic(): array
    {
        return array_map(fn($user) => $this->withoutPassword($user), $this->all());
    }

    public function findById(int $id): ?array
    {
        foreach ($this->all() as $user) {
            if ((int) $user['id'] === $id) {
                return $user;
            }
        }

        return null;
    }

    public function findByEmail(string $email): ?array
    {
        foreach ($this->all() as $user) {
            if (mb_strtolower($user['email']) === mb_strtolower($email)) {
                return $user;
            }
        }

        return null;
    }

    public function create(string $name, string $email, string $password): array
    {
        $users = $this->all();
        $ids = array_column($users, 'id');
        $nextId = empty($ids) ? 1 : max($ids) + 1;

        $user = [
            'id' => $nextId,
            'name' => $name,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $users[] = $user;
        $this->save($users);

        return $this->withoutPassword($user);
    }

    public function updatePassword(int $id, string $password): ?array
    {
        $users = $this->all();

        foreach ($users as $index => $user) {
            if ((int) $user['id'] === $id) {
                $users[$index]['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
                $users[$index]['updated_at'] = date('Y-m-d H:i:s');
                $this->save($users);

                return $this->withoutPassword($users[$index]);
            }
        }

        return null;
    }

    public function delete(int $id): bool
    {
        $users = $this->all();
        $filtered = array_values(array_filter($users, fn($user) => (int) $user['id'] !== $id));

        if (count($filtered) === count($users)) {
            return false;
        }

        $this->save($filtered);
        return true;
    }

    private function save(array $users): void
    {
        file_put_contents(
            $this->file,
            json_encode($users, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );
    }

    private function withoutPassword(array $user): array
    {
        unset($user['password_hash']);
        return $user;
    }

    private function ensureDataFile(): void
    {
        $dir = dirname($this->file);

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        if (!file_exists($this->file) || trim((string) file_get_contents($this->file)) === '') {
            $defaults = [
                [
                    'id' => 1,
                    'name' => 'Администратор',
                    'email' => 'admin@test.com',
                    'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
                    'created_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'name' => 'Пользователь',
                    'email' => 'user@test.com',
                    'password_hash' => password_hash('user123', PASSWORD_DEFAULT),
                    'created_at' => date('Y-m-d H:i:s'),
                ],
            ];

            $this->save($defaults);
        }
    }
}