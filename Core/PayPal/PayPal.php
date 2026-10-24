<?php

namespace Core\PayPal;

class PayPal
{
    protected $clientId;
    protected $secret;
    protected $baseUrl;

    public function __construct($config)
    {
        $this->clientId = $config['client_id'];
        $this->secret = $config['secret'];
        $this->baseUrl = $config['base_url'];
    }

    public function obtenerToken()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->baseUrl . '/v1/oauth2/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_USERPWD => $this->clientId . ':' . $this->secret,
            CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Accept-Language: es_MX',
                'Content-Type: application/x-www-form-urlencoded',
            ],
        ]);

        $respuesta = curl_exec($curl);
        $codigo = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);

        curl_close($curl);

        if ($respuesta === false) {
            throw new \RuntimeException(
                'Error de conexión con PayPal: ' . $error
            );
        }

        $datos = json_decode($respuesta, true);

        if ($codigo !== 200 || !isset($datos['access_token'])) {
            throw new \RuntimeException(
                'PayPal rechazó la autenticación. HTTP ' . $codigo
            );
        }

        return $datos['access_token'];
    }

    // Orden de PayPal
    public function crearOrden($monto, $moneda = 'MXN')
    {
        if (!is_numeric($monto) || (float) $monto <= 0) {
            throw new \InvalidArgumentException(
                'El monto debe ser mayor que cero.'
            );
        }

        $monto = number_format((float) $monto, 2, '.', '');
        $token = $this->obtenerToken();

        $datosOrden = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => $moneda,
                        'value' => $monto
                    ]
                ]
            ],
            'application_context' => [
                'return_url' => 'http://localhost/ProyectoPWCI/public/paypal/retorno',
                'cancel_url' => 'http://localhost/ProyectoPWCI/public/paypal/cancelado'
            ]
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->baseUrl . '/v2/checkout/orders',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($datosOrden),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            ],
        ]);

        $respuesta = curl_exec($curl);
        $codigo = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);

        curl_close($curl);

        if ($respuesta === false) {
            throw new \RuntimeException(
                'Error de conexión con PayPal: ' . $error
            );
        }

        $datos = json_decode($respuesta, true);

        if ($codigo < 200 || $codigo >= 300
            || !isset($datos['id'])) {
            throw new \RuntimeException(
                'No se pudo crear la orden. HTTP ' . $codigo
            );
        }

        return $datos;
    }

    
    // Consultar el estado de una orden
    public function consultarOrden($idOrden)
    {
        $token = $this->obtenerToken();

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->baseUrl . '/v2/checkout/orders/' . rawurlencode($idOrden),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPGET => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            ],
        ]);

        $respuesta = curl_exec($curl);
        $codigo = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);

        curl_close($curl);

        if ($respuesta === false) {
            throw new \RuntimeException(
                'Error de conexión con PayPal: ' . $error
            );
        }

        $datos = json_decode($respuesta, true);

        if ($codigo !== 200 || !isset($datos['id'])) {
            throw new \RuntimeException(
                'No se pudo consultar la orden. HTTP ' . $codigo
            );
        }

        return $datos;
    }

    
    // Capturar el pago de una orden aprobada
    public function capturarOrden($idOrden)
    {
        $token = $this->obtenerToken();

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->baseUrl . '/v2/checkout/orders/'
                . rawurlencode($idOrden) . '/capture',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => '{}',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            ],
        ]);

        $respuesta = curl_exec($curl);
        $codigo = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);

        curl_close($curl);

        if ($respuesta === false) {
            throw new \RuntimeException(
                'Error de conexión con PayPal: ' . $error
            );
        }

        $datos = json_decode($respuesta, true);

        if ($codigo < 200 || $codigo >= 300
            || !isset($datos['id'])) {
            throw new \RuntimeException(
                'No se pudo capturar el pago. HTTP ' . $codigo
            );
        }

        return $datos;
    }

}