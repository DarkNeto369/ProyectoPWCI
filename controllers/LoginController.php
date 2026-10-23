<?php

namespace Controllers;

use Models\Usuario;

class LoginController
{
    public function iniciarSesion()
    {
        // Verificar el método HTTP
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->responder(405, [
                'error' => 'Metodo no permitido.'
            ]);
        }

        // Leer el JSON enviado desde Postman
        $contenido = file_get_contents('php://input');
        $datos = json_decode($contenido, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($datos)) {
            $this->responder(400, [
                'error' => 'El JSON enviado no es valido.'
            ]);
        }

        // Obtener correo y contraseña
        $correo = trim($datos['correo'] ?? '');
        $contra = $datos['contra'] ?? '';

        // Validar correo
        if (
            !is_string($correo) ||
            $correo === '' ||
            !filter_var($correo, FILTER_VALIDATE_EMAIL)
        ) {
            $this->responder(400, [
                'error' => 'Debes proporcionar un correo valido.'
            ]);
        }

        // Validar contraseña
        if (!is_string($contra) || $contra === '') {
            $this->responder(400, [
                'error' => 'La contraseña es obligatoria.'
            ]);
        }

        try {
            // Buscar usuario
            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->buscarParaLogin($correo);

            // Verificar contraseña y estado de la cuenta
            if (
                $usuario &&
                password_verify($contra, $usuario['contra']) &&
                $usuario['estado'] === 'activo'
            ) {
                // Guardar datos de sesión
                session_regenerate_id(true);

                $_SESSION['user_id'] = $usuario['id_usuario'];
                $_SESSION['rol'] = $usuario['rol'];

                $this->responder(200, [
                    'mensaje' => 'Inicio de sesion correcto.',
                    'usuario' => [
                        'id_usuario' => $usuario['id_usuario'],
                        'nombre' => $usuario['nombre'],
                        'apellido' => $usuario['apellido'],
                        'correo' => $usuario['correo'],
                        'rol' => $usuario['rol']
                    ]
                ]);
            }

            // Credenciales incorrectas o cuenta inactiva
            $this->responder(401, [
                'error' => 'Correo o contraseña incorrectos, o cuenta inactiva.'
            ]);

        } catch (\Throwable $e) {
            error_log($e->getMessage());

            $this->responder(500, [
                'error' => 'Ocurrio un error al iniciar sesion.'
            ]);
        }
    }

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