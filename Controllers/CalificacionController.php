<?php

namespace Controllers;

use Models\Calificacion;

class CalificacionController
{
    // Registrar una calificación
    public function registrar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->responder(405, ['error' => 'Método no permitido.']);
        }

        if (!isset($_SESSION['user_id']) || !is_numeric($_SESSION['user_id']) || (int) $_SESSION['user_id'] <= 0) {
            $this->responder(401, ['error' => 'Debes iniciar sesión.']);
        }

        if (($_SESSION['rol'] ?? '') !== 'estudiante') {
            $this->responder(403, ['error' => 'No tienes permiso para realizar esta acción.']);
        }

        $datos = json_decode(file_get_contents('php://input'), true);

        $idCurso = $datos['id_curso'] ?? null;
        $calificacion = $datos['calificacion'] ?? null;

        if (!filter_var($idCurso, FILTER_VALIDATE_INT) || (int) $idCurso <= 0) {
            $this->responder(400, ['error' => 'El ID del curso no es válido.']);
        }

        if (
            !(is_int($calificacion) || (is_string($calificacion) && ctype_digit($calificacion))) ||
            (int) $calificacion < 1 ||
            (int) $calificacion > 5
        ) {
            $this->responder(400, ['error' => 'La calificación debe ser un número entero entre 1 y 5.']);
        }

        try {
            $calificacionModel = new Calificacion();

            $calificacionModel->registrar([
                'id_usuario' => (int) $_SESSION['user_id'],
                'id_curso' => (int) $idCurso,
                'calificacion' => (int) $calificacion
            ]);

            $this->responder(201, [
                'mensaje' => 'Calificación registrada correctamente.'
            ]);

        } catch (\PDOException $e) {

            // El usuario no está inscrito en el curso
            if ($e->getCode() === '45000') {
                $this->responder(403, [
                    'error' => 'Debes estar inscrito en el curso para calificarlo.'
                ]);
            }

            // El usuario ya calificó este curso
            if (
                $e->getCode() === '23000' ||
                (isset($e->errorInfo[1]) && $e->errorInfo[1] == 1062)
            ) {
                $this->responder(409, [
                    'error' => 'Ya calificaste este curso.'
                ]);
            }

            error_log($e->getMessage());

            $this->responder(500, [
                'error' => 'Ocurrió un error al registrar la calificación.'
            ]);

        } catch (\Throwable $e) {
            error_log($e->getMessage());

            $this->responder(500, [
                'error' => 'Ocurrió un error inesperado.'
            ]);
        }
    }

    // Obtener promedio de calificaciones de un curso
    public function obtenerPromedio()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->responder(405, ['error' => 'Método no permitido.']);
        }

        $idCurso = $_GET['id_curso'] ?? null;

        if (!filter_var($idCurso, FILTER_VALIDATE_INT) || (int) $idCurso <= 0) {
            $this->responder(400, ['error' => 'El ID del curso no es válido.']);
        }

        try {
            $calificacionModel = new Calificacion();

            $resultado = $calificacionModel->obtenerPromedio((int) $idCurso);

            $this->responder(200, [
                'promedio' => (float) ($resultado['promedio'] ?? 0),
                'total_calificaciones' => (int) ($resultado['total_calificaciones'] ?? 0)
            ]);

        } catch (\Throwable $e) {
            error_log($e->getMessage());

            $this->responder(500, [
                'error' => 'Ocurrió un error al obtener las calificaciones.'
            ]);
        }
    }

    // Respuesta JSON
    private function responder($codigo, $respuesta)
    {
        http_response_code($codigo);
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode($respuesta);
        exit;
    }
}