<?php

namespace App\Repositories;

use App\Config\Database;
use App\Contracts\ProductRepositoryInterface;
use PDO;

class ProductRepository implements ProductRepositoryInterface
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function getAll(?string $search = null): array
    {
        if ($search !== null && trim($search) !== '') {
            $stmt = $this->db->prepare(
                "SELECT * FROM products WHERE name LIKE ?"
            );

            $stmt->execute(['%' . trim($search) . '%']);

            return $stmt->fetchAll();
        }

        $stmt = $this->db->query("SELECT * FROM products");

        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM products WHERE id = ?"
        );

        $stmt->execute([$id]);
        $data = $stmt->fetch();

        return $data ?: null;
    }

    public function create(array $data): array
    {
        $stmt = $this->db->prepare(
            "INSERT INTO products (category_id, name, price, stock)
             VALUES (?, ?, ?, ?)"
        );

        $stmt->execute([
            $data['category_id'],
            $data['name'],
            $data['price'],
            $data['stock']
        ]);

        return $this->findById((int) $this->db->lastInsertId());
    }

    public function update(int $id, array $data): ?array
    {
        $stmt = $this->db->prepare(
            "UPDATE products
             SET category_id = ?, name = ?, price = ?, stock = ?
             WHERE id = ?"
        );

        $stmt->execute([
            $data['category_id'],
            $data['name'],
            $data['price'],
            $data['stock'],
            $id
        ]);

        return $this->findById($id);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM products WHERE id = ?"
        );

        return $stmt->execute([$id]);
    }
}