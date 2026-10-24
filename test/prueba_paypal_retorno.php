<?php

http_response_code(200);

echo json_encode([
    'mensaje' => '¡Pago procesado correctamente!',
    'estado_aprobacion' => 'APPROVED',
    'estado_pago' => 'COMPLETED'
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);