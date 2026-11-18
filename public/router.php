
<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $uri;

// Jika URL mengarah ke folder yang memiliki index.html
if (is_dir($file)) {
    $index = rtrim($file, '/') . '/index.html';

    if (is_file($index)) {
        readfile($index);
        exit;
    }
}

// Jika file statis tersedia, biarkan PHP server menampilkannya
if (is_file($file)) {
    return false;
}

// Selain itu, arahkan ke Front Controller
require __DIR__ . '/index.php';