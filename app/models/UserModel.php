<?php
declare(strict_types=1);

class UserModel extends BaseModel
{
    protected string $table = 'users';

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO users (nama, email, password, role) VALUES (:nama, :email, :password, :role)');
        return $stmt->execute([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role'],
        ]);
    }

    public function updateUser(int $id, array $data): bool
    {
        $sql = 'UPDATE users SET nama = :nama, email = :email, role = :role';
        $params = [
            'nama' => $data['nama'],
            'email' => $data['email'],
            'role' => $data['role'],
            'id' => $id,
        ];

        if (!empty($data['password'])) {
            $sql .= ', password = :password';
            $params['password'] = $data['password'];
        }

        $sql .= ' WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function historyByUser(int $userId): array
    {
        $stmt = $this->pdo->prepare('SELECT c.*, COUNT(cd.id) AS ingredient_total, COUNT(cr.id) AS recipe_total FROM consultations c LEFT JOIN consultation_details cd ON cd.consultation_id = c.id LEFT JOIN consultation_results cr ON cr.consultation_id = c.id WHERE c.user_id = :user_id GROUP BY c.id ORDER BY c.tanggal DESC');
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function allWithCounts(): array
    {
        $stmt = $this->pdo->query('SELECT u.*, COUNT(c.id) AS consultation_total FROM users u LEFT JOIN consultations c ON c.user_id = u.id GROUP BY u.id ORDER BY u.id DESC');
        return $stmt->fetchAll();
    }
}
