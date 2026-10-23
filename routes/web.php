<?php

require_once __DIR__ . '/../controllers/RegistroController.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

$registroController = new RegistroController();

// Ruta de registro-login
if ($requestUri === '/PruebaPWCI/public/registro-login' && $requestMethod === 'GET') {
    require_once __DIR__ . '/../views/registro-login.php';
    exit;
}

// Ruta de main
if ($requestUri === '/PruebaPWCI/public/main' && $requestMethod === 'GET') {
    require_once __DIR__ . '/../views/main.php';
    exit;
}

// Ruta de login
/*if ($requestUri === '/PruebaPWCI/public/login' && $requestMethod === 'GET') {
    require_once __DIR__ . '/../views/login.php';
    exit;
}

// Procesar regustro
if ($requestUri === '/PruebaPWCI/public/registro' && $requestMethod === 'POST') {
    
    $registroController->registrar();

    exit;
}*/

// Ruta no encontrada
http_response_code(404);
echo "404 - Página no encontrada";