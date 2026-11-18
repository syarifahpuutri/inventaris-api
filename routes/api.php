<?php

use App\Core\Router;
use App\Core\Response;
use App\Controllers\ProductController;
use App\Controllers\CategoryController;

return function (
    Router $router,
    ProductController $products,
    CategoryController $categories
): void {

    $readJson = function (): array {
        $data = json_decode(
            file_get_contents('php://input'),
            true
        );

        if (!is_array($data) || array_is_list($data)) {
            Response::error('JSON object tidak valid', 400);
        }

        return $data;
    };

    // PRODUCT CRUD
    $router->add('GET', '/api/v1/products',
    function () use ($products) {
        $search = $_GET['search'] ?? null;
        
        Response::success($products->index($search));
        }
    );

    $router->add('GET', '/api/v1/products/{id}',
        function ($id) use ($products) {
            $data = $products->show($id);

            if (!$data) {
                Response::error('Produk tidak ditemukan', 404);
            }

            Response::success($data);
        }
    );

    $router->add('POST', '/api/v1/products',
        function () use ($products, $readJson) {
            Response::success(
                $products->store($readJson()),
                'Produk berhasil ditambahkan',
                201
            );
        }
    );

    $router->add('PUT', '/api/v1/products/{id}',
        function ($id) use ($products, $readJson) {
            Response::success(
                $products->update($id, $readJson()),
                'Produk berhasil diperbarui'
            );
        }
    );

    $router->add('DELETE', '/api/v1/products/{id}',
        function ($id) use ($products) {
            $products->destroy($id);
            Response::json(null, 204);
        }
    );

    // CATEGORY CRUD
    $router->add('GET', '/api/v1/categories',
        function () use ($categories) {
            Response::success($categories->index());
        }
    );

    $router->add('GET', '/api/v1/categories/{id}',
        function ($id) use ($categories) {
            $data = $categories->show($id);

            if (!$data) {
                Response::error('Kategori tidak ditemukan', 404);
            }

            Response::success($data);
        }
    );

    $router->add('POST', '/api/v1/categories',
        function () use ($categories, $readJson) {
            Response::success(
                $categories->store($readJson()),
                'Kategori berhasil ditambahkan',
                201
            );
        }
    );

    $router->add('PUT', '/api/v1/categories/{id}',
        function ($id) use ($categories, $readJson) {
            Response::success(
                $categories->update($id, $readJson()),
                'Kategori berhasil diperbarui'
            );
        }
    );

    $router->add('DELETE', '/api/v1/categories/{id}',
        function ($id) use ($categories) {
            $categories->destroy($id);
            Response::json(null, 204);
        }
    );
};