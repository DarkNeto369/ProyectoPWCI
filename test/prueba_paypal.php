<?php

use Core\App;
use Core\PayPal\PayPal;

header('Content-Type: application/json; charset=utf-8');

try {
    $paypal = App::resolve(PayPal::class);

    // Importe fijo para la prueba, no enviado por el cliente.
    $orden = $paypal->crearOrden('10.00', 'MXN');

    $urlAprobacion = null;

    foreach ($orden['links'] ?? [] as $enlace) {
        if (in_array(
            $enlace['rel'] ?? '',
            ['approve', 'payer-action'],
            true
        )) {
            $urlAprobacion = $enlace['href'];
            break;
        }
    }

    http_response_code(201);

    echo json_encode([
        'mensaje' => 'Orden creada correctamente.',
        'id_orden' => $orden['id'],
        'estado' => $orden['status'] ?? null,
        'url_aprobacion' => $urlAprobacion
    ]);

} catch (\Throwable $e) {
    http_response_code(500);

    echo json_encode([
        'error' => 'No se pudo crear la orden de PayPal.'
    ]);
}


/*use Core\App;
use Core\PayPal\PayPal;

header('Content-Type: application/json; charset=utf-8');

try {
    $paypal = App::resolve(PayPal::class);

    $orden = $paypal->consultarOrden('1KT78832X4662604S');

    http_response_code(200);

    echo json_encode([
        'id_orden' => $orden['id'],
        'estado' => $orden['status'] ?? null
    ]);

} catch (\Throwable $e) {
    http_response_code(500);

    echo json_encode([
        'error' => 'No se pudo consultar la orden.'
    ]);
}*/



/*header('Content-Type: application/json; charset=utf-8');

try {
    $paypal = App::resolve(PayPal::class);

    $orden = $paypal->capturarOrden('41Y63488U5441523J');

    http_response_code(200);

    echo json_encode([
        'mensaje' => 'Solicitud de captura procesada.',
        'id_orden' => $orden['id'],
        'estado' => $orden['status'] ?? null,
        'capturas' => $orden['purchase_units'][0]['payments']['captures'] ?? []
    ]);

} catch (\Throwable $e) {
    http_response_code(500);

    echo json_encode([
        'error' => 'No se pudo capturar el pago.'
    ]);
}*/