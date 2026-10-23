<?php

const BASE_PATH = __DIR__ . '/../';

session_start();

require BASE_PATH . 'Core/functions.php';

spl_autoload_register(function ($class) {
    // Core\Database -> Core/Database.php
    require base_path(str_replace('\\', '/', $class) . '.php');
});

(new \Core\Middleware\Cors())->handle();

require base_path('bootstrap.php');

$router = new \Core\Router();
require base_path('routes.php');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Quitar el prefijo de la carpeta del proyecto
$baseUrl = '/ProyectoPWCI/public';

if (strpos($uri, $baseUrl) === 0) {
    $uri = substr($uri, strlen($baseUrl));
}

// Si la ruta queda vacía, corresponde a la página principal
$uri = $uri === '' ? '/' : $uri;

$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);