<?php

namespace App\Services;

use App\Contracts\CategoryRepositoryInterface;

class CategoryService
{
    private CategoryRepositoryInterface $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    public function findById(int $id): ?array
    {
        return $this->repository->findById($id);
    }

    public function create(array $data): array
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): ?array
    {
        return $this->repository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}