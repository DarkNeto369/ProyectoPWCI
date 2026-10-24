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
}