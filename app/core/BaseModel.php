<?php
declare(strict_types=1);

class BaseModel
{
    protected PDO $pdo;
    protected string $table = '';
    protected string $primaryKey = 'id';

    public function __construct()
    {
        $this->pdo = db();
    }

    public function all(string $orderBy = 'id DESC'): array
    {
        $stmt = $this->pdo->query('SELECT * FROM ' . $this->table . ' ORDER BY ' . $orderBy);
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $this->primaryKey . ' = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM ' . $this->table . ' WHERE ' . $this->primaryKey . ' = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function count(): int
    {
        $stmt = $this->pdo->query('SELECT COUNT(*) AS total FROM ' . $this->table);
        return (int) ($stmt->fetch()['total'] ?? 0);
    }
}
