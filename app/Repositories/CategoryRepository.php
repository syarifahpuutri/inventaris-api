<?php

namespace App\Repositories;

use App\Config\Database;
use App\Contracts\CategoryRepositoryInterface;
use PDO;

class CategoryRepository implements CategoryRepositoryInterface
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM categories");
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();

        return $data ?: null;
    }

    public function create(array $data): array
    {
        $stmt = $this->db->prepare(
            "INSERT INTO categories (name, description) VALUES (?, ?)"
        );
        $stmt->execute([$data['name'], $data['description']]);

        return $this->findById((int) $this->db->lastInsertId());
    }

    public function update(int $id, array $data): ?array
    {
        $stmt = $this->db->prepare(
            "UPDATE categories SET name = ?, description = ? WHERE id = ?"
        );
        $stmt->execute([$data['name'], $data['description'], $id]);

        return $this->findById($id);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$id]);
    }
}