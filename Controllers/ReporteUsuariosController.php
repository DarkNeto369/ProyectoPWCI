<?php

namespace Controllers;

use Models\ReporteUsuarios;

class ReporteUsuariosController
{
    // 1. Obtener el reporte de usuarios (Solo administradores)
    public function obtener()
    {
        // Verificar método GET
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            exit('Metodo no permitido.');
        }

        // Verificar sesión
        $idUsuario = $_SESSION['user_id'] ?? null;

        if (
            $idUsuario === null ||
            !ctype_digit((string) $idUsuario) ||
            (int) $idUsuario <= 0
        ) {
            http_response_code(401);
            exit('Debes iniciar sesion.');
        }

        // Verificar que sea administrador
        if (($_SESSION['rol'] ?? '') !== 'administrador') {
            http_response_code(403);
            exit('No tienes permisos para consultar este reporte.');
        }

        // Obtener el tipo de usuario seleccionado
        $tipo = $_GET['tipo'] ?? 'instructor';

        if (!in_array($tipo, ['instructor', 'estudiante'], true)) {
            http_response_code(400);
            exit('Debes seleccionar un tipo de usuario valido.');
        }

        // Determinar la opción del procedimiento almacenado
        $opcion = ($tipo === 'instructor') ? 1 : 2;

        try {
            $reporteModel = new ReporteUsuarios();

            $usuarios = $reporteModel->obtenerReporte($opcion);

            // Mostrar la vista con los resultados
            require __DIR__ . '/../views/reporte-usuarios.php';

        } catch (\Throwable $e) {

            error_log($e->getMessage());

            http_response_code(500);
            exit('Ocurrio un error al obtener el reporte de usuarios.');
        }
    }
}