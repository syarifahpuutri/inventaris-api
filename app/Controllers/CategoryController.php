<?php

namespace App\Controllers;

use App\Services\CategoryService;

class CategoryController
{
    private CategoryService $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function index(): array
    {
        return $this->service->getAll();
    }

    public function show(int $id): ?array
    {
        return $this->service->findById($id);
    }

    public function store(array $data): array
    {
        return $this->service->create($data);
    }

    public function update(int $id, array $data): ?array
    {
        return $this->service->update($id, $data);
    }

    public function destroy(int $id): bool
    {
        return $this->service->delete($id);
    }
}