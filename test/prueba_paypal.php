<?php

use Core\App;
use Core\PayPal\PayPal;

header('Content-Type: application/json; charset=utf-8');

try {
    $paypal = App::resolve(PayPal::class);

    $token = $paypal->obtenerToken();

    http_response_code(200);

    echo json_encode([
        'mensaje' => 'Conexión con PayPal Sandbox exitosa.'
    ]);
} catch (\Throwable $e) {
    http_response_code(500);

    echo json_encode([
        'error' => 'No se pudo conectar con PayPal Sandbox.'
    ]);
}