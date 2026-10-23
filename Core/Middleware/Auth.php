<?php

namespace Core\Middleware;

class Auth
{
    public function handle($rolRequerido = null)
    {
        // Validar sesión
        if (!isset($_SESSION['user_id'], $_SESSION['rol'])) {
            $this->responder(401, [
                'error' => 'Debes iniciar sesion para acceder a esta ruta.'
            ]);
        }

        // Si la ruta no exige un rol específico,
        // basta con tener una sesión válida
        if ($rolRequerido === null) {
            return;
        }

        // Validar que el rol solicitado sea válido
        $rolesPermitidos = [
            'administrador',
            'estudiante',
            'instructor'
        ];

        if (!in_array($rolRequerido, $rolesPermitidos, true)) {
            $this->responder(500, [
                'error' => 'El rol configurado para la ruta no es valido.'
            ]);
        }

        // Validar el rol del usuario
        if ($_SESSION['rol'] !== $rolRequerido) {
            $this->responder(403, [
                'error' => 'No tienes permisos para acceder a esta ruta.'
            ]);
        }
    }

    private function responder($codigo, $respuesta)
    {
        http_response_code($codigo);
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        exit;
    }
}