<?php

namespace Controllers;

use Models\Comentario;

class ComentarioController
{
    // 1. Registrar un comentario
    public function registrar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->responder(405, [
                'error' => 'Metodo no permitido.'
            ]);
        }

        // Obtener el usuario desde la sesión
        $idUsuario = $_SESSION['user_id'] ?? null;

        if (
            $idUsuario === null ||
            !ctype_digit((string) $idUsuario) ||
            (int) $idUsuario <= 0
        ) {
            $this->responder(401, [
                'error' => 'Debes iniciar sesion para comentar.'
            ]);
        }

        // Verificar que sea estudiante
        if (($_SESSION['rol'] ?? '') !== 'estudiante') {
            $this->responder(403, [
                'error' => 'Solo los estudiantes pueden comentar.'
            ]);
        }

        // Recibir los datos JSON
        $datos = json_decode(
            file_get_contents('php://input'),
            true
        );

        if (!is_array($datos)) {
            $this->responder(400, [
                'error' => 'Debes enviar datos JSON validos.'
            ]);
        }

        $idCurso = $datos['id_curso'] ?? null;
        $comentario = trim($datos['comentario'] ?? '');

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

        // Validar comentario
        if ($comentario === '') {
            $this->responder(400, [
                'error' => 'El comentario no puede estar vacio.'
            ]);
        }

        try {
            $comentarioModel = new Comentario();

            $resultado = $comentarioModel->registrar([
                'id_usuario' => (int) $idUsuario,
                'id_curso' => (int) $idCurso,
                'comentario' => $comentario
            ]);

            $this->responder(201, [
                'mensaje' => 'Comentario registrado correctamente.',
                'comentario' => $resultado
            ]);

        } catch (\PDOException $e) {

            error_log($e->getMessage());

            // El procedimiento indica que el usuario no está inscrito
            if ($e->getCode() === '45000') {
                $this->responder(403, [
                    'error' => 'Debes estar inscrito en el curso para comentar.'
                ]);
            }

            $this->responder(500, [
                'error' => 'Ocurrio un error al registrar el comentario.'
            ]);

        } catch (\Throwable $e) {

            error_log($e->getMessage());

            $this->responder(500, [
                'error' => 'Ocurrio un error al registrar el comentario.'
            ]);
        }
    }

    // 2. Obtener los comentarios de un curso
    public function obtener()
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
            $comentarioModel = new Comentario();

            $comentarios = $comentarioModel->obtenerPorCurso(
                (int) $idCurso
            );

            $this->responder(200, [
                'comentarios' => $comentarios
            ]);

        } catch (\Throwable $e) {

            error_log($e->getMessage());

            $this->responder(500, [
                'error' => 'Ocurrio un error al recuperar los comentarios.'
            ]);
        }
    }

    // 3. Eliminar un comentario (Solo administradores)
    public function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->responder(405, [
                'error' => 'Metodo no permitido.'
            ]);
        }

        // Verificar sesión
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

        // Verificar que sea administrador
        if (($_SESSION['rol'] ?? '') !== 'administrador') {
            $this->responder(403, [
                'error' => 'No tienes permisos para eliminar comentarios.'
            ]);
        }

        // Recibir los datos JSON
        $datos = json_decode(
            file_get_contents('php://input'),
            true
        );

        if (!is_array($datos)) {
            $this->responder(400, [
                'error' => 'Debes enviar datos JSON validos.'
            ]);
        }

        $idComentario = $datos['id_comentario'] ?? null;

        if (
            $idComentario === null ||
            !ctype_digit((string) $idComentario) ||
            (int) $idComentario <= 0
        ) {
            $this->responder(400, [
                'error' => 'Debes proporcionar un id_comentario valido.'
            ]);
        }

        try {
            $comentarioModel = new Comentario();

            $comentarioModel->eliminar((int) $idComentario);

            $this->responder(200, [
                'mensaje' => 'Comentario eliminado correctamente.'
            ]);

        } catch (\Throwable $e) {

            error_log($e->getMessage());

            $this->responder(500, [
                'error' => 'Ocurrio un error al eliminar el comentario.'
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