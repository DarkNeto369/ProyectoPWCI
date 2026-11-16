<?php

namespace Controllers;

use Models\Inscripcion;

class InscripcionController
{
    // 1. Registrar la compra de un curso
    public function comprar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->responder(405, [
                'error' => 'Metodo no permitido.'
            ]);
        }

        // Obtener el estudiante desde la sesión
        $idUsuario = $_SESSION['user_id'] ?? null;

        if (
            $idUsuario === null ||
            !ctype_digit((string) $idUsuario) ||
            (int) $idUsuario <= 0
        ) {
            $this->responder(401, [
                'error' => 'Debes iniciar sesion para comprar un curso.'
            ]);
        }

        // Verificar que sea estudiante
        if (($_SESSION['rol'] ?? '') !== 'estudiante') {
            $this->responder(403, [
                'error' => 'Solo los estudiantes pueden comprar cursos.'
            ]);
        }

        // Recibir los datos enviados en JSON
        $datos = json_decode(
            file_get_contents('php://input'),
            true
        );

        if (!is_array($datos)) {
            $this->responder(400, [
                'error' => 'Los datos enviados no son validos.'
            ]);
        }

        $idCurso = $datos['id_curso'] ?? null;

        // Validar ID del curso
        if (
            $idCurso === null ||
            !ctype_digit((string) $idCurso) ||
            (int) $idCurso <= 0
        ) {
            $this->responder(400, [
                'error' => 'Debes proporcionar un id_curso valido.'
            ]);
        }

        try {

            $inscripcionModel = new Inscripcion();

            $resultado = $inscripcionModel->registrar(
                (int) $idUsuario,
                (int) $idCurso
            );

            $this->responder(201, [
                'mensaje' => 'Curso comprado e inscrito correctamente.',
                'inscripcion' => $resultado
            ]);

        } catch (\Throwable $e) {

            error_log($e->getMessage());

            // Evitar inscripciones duplicadas
            if ($e->getCode() === '23000') {
                $this->responder(409, [
                    'error' => 'Ya estas inscrito en este curso.'
                ]);
            }

            // Errores enviados por el stored procedure
            if ($e->getCode() === '45000') {
                $this->responder(400, [
                    'error' => $e->getMessage()
                ]);
            }

            $this->responder(500, [
                'error' => 'Ocurrio un error al registrar la compra.'
            ]);
        }
    }

    // 2. Obtener los cursos inscritos del estudiante
    public function misCursos()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->responder(405, [
                'error' => 'Metodo no permitido.'
            ]);
        }

        // Obtener estudiante desde la sesión
        $idUsuario = $_SESSION['user_id'] ?? null;

        if (
            $idUsuario === null ||
            !ctype_digit((string) $idUsuario) ||
            (int) $idUsuario <= 0
        ) {
            $this->responder(401, [
                'error' => 'Debes iniciar sesion para consultar tus cursos.'
            ]);
        }

        // Verificar que sea estudiante
        if (($_SESSION['rol'] ?? '') !== 'estudiante') {
            $this->responder(403, [
                'error' => 'Solo los estudiantes pueden consultar sus cursos.'
            ]);
        }

        try {

            $inscripcionModel = new Inscripcion();

            $cursos = $inscripcionModel->obtenerPorUsuario(
                (int) $idUsuario
            );

            $this->responder(200, [
                'cursos' => $cursos
            ]);

        } catch (\Throwable $e) {

            error_log($e->getMessage());

            $this->responder(500, [
                'error' => 'Ocurrio un error al consultar tus cursos.'
            ]);
        }
    }

    // 3. Obtener los niveles de un curso inscrito
    public function obtenerNiveles()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->responder(405, [
                'error' => 'Metodo no permitido.'
            ]);
        }

        $idUsuario = $_SESSION['user_id'] ?? null;

        if (
            $idUsuario === null ||
            !ctype_digit((string) $idUsuario) ||
            (int) $idUsuario <= 0
        ) {
            $this->responder(401, [
                'error' => 'Debes iniciar sesion.'
            ]);
        }

        if (($_SESSION['rol'] ?? '') !== 'estudiante') {
            $this->responder(403, [
                'error' => 'Solo los estudiantes pueden consultar los niveles.'
            ]);
        }

        $idInscripcion = $_GET['id_inscripcion'] ?? null;

        if (
            $idInscripcion === null ||
            !ctype_digit((string) $idInscripcion) ||
            (int) $idInscripcion <= 0
        ) {
            $this->responder(400, [
                'error' => 'Debes proporcionar un id_inscripcion valido.'
            ]);
        }

        try {

            $inscripcionModel = new Inscripcion();

            $niveles = $inscripcionModel->obtenerNiveles(
                (int) $idInscripcion,
                (int) $idUsuario
            );

            $this->responder(200, [
                'niveles' => $niveles
            ]);

        } catch (\Throwable $e) {

            error_log($e->getMessage());

            $this->responder(500, [
                'error' => 'Ocurrio un error al consultar los niveles.'
            ]);
        }
    }

    // 4. Marcar un nivel como completado
    public function marcarNivelCompletado()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->responder(405, [
                'error' => 'Metodo no permitido.'
            ]);
        }

        $idUsuario = $_SESSION['user_id'] ?? null;

        if (
            $idUsuario === null ||
            !ctype_digit((string) $idUsuario) ||
            (int) $idUsuario <= 0
        ) {
            $this->responder(401, [
                'error' => 'Debes iniciar sesion.'
            ]);
        }

        if (($_SESSION['rol'] ?? '') !== 'estudiante') {
            $this->responder(403, [
                'error' => 'Solo los estudiantes pueden completar niveles.'
            ]);
        }

        $datos = json_decode(file_get_contents('php://input'), true);

        if (!is_array($datos)) {
            $this->responder(400, [
                'error' => 'Los datos enviados no son validos.'
            ]);
        }

        $idInscripcion = $datos['id_inscripcion'] ?? null;
        $idNivel = $datos['id_nivel'] ?? null;

        if (
            $idInscripcion === null ||
            !ctype_digit((string) $idInscripcion) ||
            (int) $idInscripcion <= 0
        ) {
            $this->responder(400, [
                'error' => 'Debes proporcionar un id_inscripcion valido.'
            ]);
        }

        if (
            $idNivel === null ||
            !ctype_digit((string) $idNivel) ||
            (int) $idNivel <= 0
        ) {
            $this->responder(400, [
                'error' => 'Debes proporcionar un id_nivel valido.'
            ]);
        }

        try {

            $inscripcionModel = new Inscripcion();

            $resultado = $inscripcionModel->marcarNivelCompletado(
                (int) $idInscripcion,
                (int) $idUsuario,
                (int) $idNivel
            );

            $this->responder(200, [
                'mensaje' => 'Nivel marcado como completado.',
                'resultado' => $resultado
            ]);

        } catch (\Throwable $e) {

            error_log($e->getMessage());

            if ($e->getCode() === '45000') {
                $this->responder(400, [
                    'error' => $e->getMessage()
                ]);
            }

            $this->responder(500, [
                'error' => 'Ocurrio un error al completar el nivel.'
            ]);
        }
    }

    // Obtener los datos del diploma
public function diploma()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        $this->responder(405, [
            'error' => 'Método no permitido.'
        ]);
    }

    if (
        !isset($_SESSION['user_id']) ||
        $_SESSION['rol'] !== 'estudiante'
    ) {
        $this->responder(403, [
            'error' => 'No tienes permiso para consultar este diploma.'
        ]);
    }

    $idInscripcion = $_GET['id_inscripcion'] ?? null;

    if (!$idInscripcion || !ctype_digit((string) $idInscripcion)) {
        $this->responder(400, [
            'error' => 'Identificador de inscripción inválido.'
        ]);
    }

    try {

        $modelo = new Inscripcion();

        $diploma = $modelo->obtenerDiploma(
            $idInscripcion,
            $_SESSION['user_id']
        );

        if (!$diploma) {
            $this->responder(404, [
                'error' => 'No se encontraron los datos del diploma.'
            ]);
        }

        $this->responder(200, [
            'mensaje' => 'Datos del diploma obtenidos correctamente.',
            'diploma' => $diploma
        ]);

    } catch (\PDOException $e) {

        $this->responder(400, [
            'error' => $e->getMessage()
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