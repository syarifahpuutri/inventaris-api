<?php

namespace App\Services;

use App\Contracts\ProductRepositoryInterface;
use App\Exceptions\NotFoundException;
use InvalidArgumentException;

class ProductService
{
    public function __construct(
        private ProductRepositoryInterface $repository
    ) {}

    public function getAll(?string $search = null): array
    {
        return $this->repository->getAll($search);
    }

    public function findById(int $id): array
    {
        $product = $this->repository->findById($id);

        if (!$product) {
            throw new NotFoundException(
                "Produk tidak ditemukan"
            );
        }

        return $product;
    }

    public function create(array $data): array
    {
        if (empty(trim($data['name'] ?? ''))) {
            throw new InvalidArgumentException(
                "Nama produk wajib diisi"
            );
        }

        if (
            !isset($data['category_id']) ||
            filter_var($data['category_id'], FILTER_VALIDATE_INT) === false ||
            (int) $data['category_id'] < 1
        ) {
            throw new InvalidArgumentException(
                "Kategori tidak valid"
            );
        }

        if (
            !isset($data['price']) ||
            !is_numeric($data['price']) ||
            !is_finite((float) $data['price']) ||
            (float) $data['price'] < 0
        ) {
            throw new InvalidArgumentException(
                "Harga harus berupa angka nonnegatif"
            );
        }

        if (
            !isset($data['stock']) ||
            filter_var($data['stock'], FILTER_VALIDATE_INT) === false ||
            (int) $data['stock'] < 0
        ) {
            throw new InvalidArgumentException(
                "Stok harus berupa bilangan bulat nonnegatif"
            );
        }

        return $this->repository->create([
            'category_id' => (int) $data['category_id'],
            'name' => trim($data['name']),
            'price' => (float) $data['price'],
            'stock' => (int) $data['stock']
        ]);
    }

    public function update(int $id, array $data): ?array
    {
        $this->findById($id);

        if (empty(trim($data['name'] ?? ''))) {
            throw new InvalidArgumentException(
                "Nama produk wajib diisi"
            );
        }

        if (
            !isset($data['category_id']) ||
            filter_var($data['category_id'], FILTER_VALIDATE_INT) === false ||
            (int) $data['category_id'] < 1
        ) {
            throw new InvalidArgumentException(
                "Kategori tidak valid"
            );
        }

        if (
            !isset($data['price']) ||
            !is_numeric($data['price']) ||
            !is_finite((float) $data['price']) ||
            (float) $data['price'] < 0
        ) {
            throw new InvalidArgumentException(
                "Harga tidak valid"
            );
        }

        if (
            !isset($data['stock']) ||
            filter_var($data['stock'], FILTER_VALIDATE_INT) === false ||
            (int) $data['stock'] < 0
        ) {
            throw new InvalidArgumentException(
                "Stok tidak valid"
            );
        }

        return $this->repository->update($id, [
            'category_id' => (int) $data['category_id'],
            'name' => trim($data['name']),
            'price' => (float) $data['price'],
            'stock' => (int) $data['stock']
        ]);
    }

    public function delete(int $id): bool
    {
        $this->findById($id);

        return $this->repository->delete($id);
    }
}