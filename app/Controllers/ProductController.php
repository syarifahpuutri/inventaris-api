<?php

namespace App\Controllers;

use App\Services\ProductService;

class ProductController
{
    private ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index(?string $search = null): array
    {
        return $this->service->getAll($search);
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