<?php

namespace Controllers;

use Models\Usuario;

class RegistroController
{
    public function registrar()
    {
        // 1. Peticiones POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->responder(405, [
                'error' => 'Metodo no permitido.'
            ]);
        }

        // 2. Recibir los datos JSON enviados desde Postman
        $contenido = file_get_contents('php://input');
        $datos = json_decode($contenido, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($datos)) {
            $this->responder(400, [
                'error' => 'El JSON enviado no es valido.'
            ]);
        }

        // 3. Validar los campos obligatorios
        $correo = trim($datos['correo'] ?? '');
        $contra = $datos['contra'] ?? '';

        if ($correo === '' || !is_string($correo) ||
            !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $this->responder(400, [
                'error' => 'Debes proporcionar un correo valido.'
            ]);
        }

        if (!is_string($contra) || $contra === '') {
            $this->responder(400, [
                'error' => 'La contraseña es obligatoria.'
            ]);
        }

        // 4. Validar los campos opcionales
        $genero = $datos['genero'] ?? null;

        if ($genero !== null &&
            !in_array($genero, ['Hombre', 'Mujer', 'Otro'], true)) {
            $this->responder(400, [
                'error' => 'El genero no es valido.'
            ]);
        }

        $rol = $datos['rol'] ?? null;

        // No registrar administradores públicamente
        if ($rol !== null &&
            !in_array($rol, ['estudiante', 'instructor'], true)) {
            $this->responder(400, [
                'error' => 'El rol no es valido.'
            ]);
        }

        $fechaNacimiento = $datos['fecha_nacimiento'] ?? null;

        if ($fechaNacimiento !== null) {
            $fecha = \DateTime::createFromFormat('!Y-m-d', $fechaNacimiento);

            if (!$fecha || $fecha->format('Y-m-d') !== $fechaNacimiento) {
                $this->responder(400, [
                    'error' => 'La fecha de nacimiento no es valida. Usa AAAA-MM-DD.'
                ]);
            }
        }

        // 5. Modelo
        try {
            $usuarioModel = new Usuario();

            // Comprobar si el correo ya está registrado
            $usuarioExistente = $usuarioModel->buscarPorCorreo($correo);

            if ($usuarioExistente) {
                $this->responder(409, [
                    'error' => 'El correo ya esta registrado.'
                ]);
            }

            // 6. Preparar los datos
            $datosUsuario = [
                'imagen_perfil' => $datos['imagen_perfil'] ?? null,
                'nombre' => $datos['nombre'] ?? null,
                'apellido' => $datos['apellido'] ?? null,
                'genero' => $genero,
                'fecha_nacimiento' => $fechaNacimiento,
                'rol' => $rol,
                'correo' => $correo,
                'contra' => password_hash($contra, PASSWORD_DEFAULT)
            ];

            // 7. Registrar mediante el modelo y el procedimiento almacenado
            $usuarioModel->registrar($datosUsuario);

            // 8. Responder con JSON
            $this->responder(201, [
                'mensaje' => 'Usuario registrado correctamente.'
            ]);

        } catch (\Throwable $e) {
            error_log($e->getMessage());

            $this->responder(500, [
                'error' => 'Ocurrio un error al registrar el usuario.',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    // Enviar respuestas JSON con su código HTTP
    private function responder($codigo, $respuesta)
    {
        http_response_code($codigo);
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode(
            $respuesta,
            JSON_UNESCAPED_UNICODE
        );

        exit;
    }
}