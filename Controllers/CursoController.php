<?php

namespace Controllers;

use Models\Curso;

class CursoController
{
    // 1. Agregar un curso
    public function agregar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->responder(405, [
                'error' => 'Metodo no permitido.'
            ]);
        }

        $contenido = file_get_contents('php://input');
        $datos = json_decode($contenido, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($datos)) {
            $this->responder(400, [
                'error' => 'El JSON enviado no es valido.'
            ]);
        }

        // Validar el instructor
        $idInstructor = $datos['id_instructor'] ?? null;

        if (
            !is_int($idInstructor) &&
            !(is_string($idInstructor) && ctype_digit($idInstructor))
        ) {
            $this->responder(400, [
                'error' => 'Debes proporcionar un id_instructor valido.'
            ]);
        }

        if ((int) $idInstructor <= 0) {
            $this->responder(400, [
                'error' => 'El id_instructor debe ser mayor que cero.'
            ]);
        }

        // Validar los campos del curso
        $categoria = trim($datos['categoria'] ?? '');
        $titulo = trim($datos['titulo'] ?? '');
        $descripcion = trim($datos['descripcion'] ?? '');
        $costo = $datos['costo'] ?? null;

        if ($categoria === '') {
            $this->responder(400, [
                'error' => 'La categoria es obligatoria.'
            ]);
        }

        if ($titulo === '') {
            $this->responder(400, [
                'error' => 'El titulo es obligatorio.'
            ]);
        }

        if ($descripcion === '') {
            $this->responder(400, [
                'error' => 'La descripcion es obligatoria.'
            ]);
        }

        if (
            $costo === null ||
            !is_numeric($costo) ||
            !is_finite((float) $costo) ||
            (float) $costo < 0
        ) {
            $this->responder(400, [
                'error' => 'Debes proporcionar un costo valido.'
            ]);
        }

        try {
            $cursoModel = new Curso();

            $datosCurso = [
                'id_instructor' => (int) $idInstructor,
                'categoria' => $categoria,
                'titulo' => $titulo,
                'descripcion' => $descripcion,
                'costo' => $costo,
                'imagen' => $datos['imagen'] ?? null
            ];

            $curso = $cursoModel->agregar($datosCurso);

            $this->responder(201, [
                'mensaje' => 'Curso agregado correctamente.',
                'curso' => $curso
            ]);

        } catch (\Throwable $e) {
            error_log($e->getMessage());

            $this->responder(500, [
                'error' => 'Ocurrio un error al agregar el curso.',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    // 2. Obtener los cursos recientes
    public function recientes()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->responder(405, [
                'error' => 'Metodo no permitido.'
            ]);
        }

        try {
            $cursoModel = new Curso();
            $cursos = $cursoModel->obtenerRecientes();

            $this->responder(200, [
                'cursos' => $cursos
            ]);

        } catch (\Throwable $e) {
            error_log($e->getMessage());

            $this->responder(500, [
                'error' => 'Ocurrio un error al recuperar los cursos recientes.',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    // 3. Obtener los cursos de un instructor
    public function porInstructor()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->responder(405, [
                'error' => 'Metodo no permitido.'
            ]);
        }

        $idInstructor = $_GET['id_instructor'] ?? null;

        if (
            $idInstructor === null ||
            !ctype_digit((string) $idInstructor) ||
            (int) $idInstructor <= 0
        ) {
            $this->responder(400, [
                'error' => 'Debes proporcionar un id_instructor valido.'
            ]);
        }

        try {
            $cursoModel = new Curso();

            $cursos = $cursoModel->obtenerPorInstructor(
                (int) $idInstructor
            );

            $this->responder(200, [
                'cursos' => $cursos
            ]);

        } catch (\Throwable $e) {
            error_log($e->getMessage());

            $this->responder(500, [
                'error' => 'Ocurrio un error al recuperar los cursos del instructor.',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    // 4. Obtener el detalle de un curso y sus niveles
    public function detalle()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->responder(405, [
                'error' => 'Metodo no permitido.'
            ]);
        }

        $idCurso = $_GET['id_curso'] ?? null;

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
            $cursoModel = new Curso();
            $detalle = $cursoModel->obtenerDetalle((int) $idCurso);

            if (
                !isset($detalle['curso']) ||
                $detalle['curso'] === false ||
                $detalle['curso'] === null
            ) {
                $this->responder(404, [
                    'error' => 'El curso no existe.'
                ]);
            }

            $this->responder(200, $detalle);

        } catch (\Throwable $e) {
            error_log($e->getMessage());

            $this->responder(500, [
                'error' => 'Ocurrio un error al recuperar el detalle del curso.',
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