<?php

namespace Core\Middleware;

class Cors
{
    private const ORIGENES_PERMITIDOS = [
        'http://localhost'
    ];

    public function handle()
    {
        $origen = $_SERVER['HTTP_ORIGIN'] ?? null;

        // Rechazar orígenes no autorizados.
        if (
            $origen !== null &&
            !in_array($origen, self::ORIGENES_PERMITIDOS, true)
        ) {
            http_response_code(403);

            header('Content-Type: application/json; charset=utf-8');

            echo json_encode([
                'error' => 'Origen no autorizado por CORS.'
            ], JSON_UNESCAPED_UNICODE);

            exit;
        }

        // Permitir el origen autorizado.
        if ($origen !== null) {
            header('Access-Control-Allow-Origin: ' . $origen);
            header('Vary: Origin');

            // Permitir el envío de cookies de sesión.
            header('Access-Control-Allow-Credentials: true');

            header(
                'Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS'
            );

            header(
                'Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With'
            );
        }

        // Responder a las solicitudes previas del navegador.
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit;
        }
    }
}