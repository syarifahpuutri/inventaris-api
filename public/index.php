<?php

declare(strict_types=1);

use App\Core\Router;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Services\ProductService;
use App\Services\CategoryService;
use App\Controllers\ProductController;
use App\Controllers\CategoryController;
use App\Middleware\ErrorHandler;

require dirname(__DIR__) . '/vendor/autoload.php';

use Dotenv\Dotenv;

Dotenv::createImmutable(dirname(__DIR__))->load();

// Register Error Handler
ErrorHandler::register();

// Repository
$productRepository = new ProductRepository();
$categoryRepository = new CategoryRepository();

// Service
$productService = new ProductService($productRepository);
$categoryService = new CategoryService($categoryRepository);

// Controller
$productController = new ProductController($productService);
$categoryController = new CategoryController($categoryService);

// Router
$router = new Router();

// Register Routes
$registerRoutes = require dirname(__DIR__) . '/routes/api.php';

$registerRoutes(
    $router,
    $productController,
    $categoryController
);

// Dispatch
$router->dispatch(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI']
);