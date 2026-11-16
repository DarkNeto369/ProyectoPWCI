<?php

namespace Controllers;

use Models\Mensaje;

class MensajeController
{
    // 1. Enviar un mensaje
    public function enviar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->responder(405, [
                'error' => 'Método no permitido.'
            ]);
        }

        if (
            !isset($_SESSION['user_id'], $_SESSION['rol']) ||
            !in_array($_SESSION['rol'], ['estudiante', 'instructor'])
        ) {
            $this->responder(403, [
                'error' => 'No tienes permiso para enviar mensajes.'
            ]);
        }

        $datos = json_decode(file_get_contents('php://input'), true);

        if (!is_array($datos)) {
            $this->responder(400, [
                'error' => 'Los datos enviados no son válidos.'
            ]);
        }

        $idCurso = $datos['id_curso'] ?? null;
        $idContacto = $datos['id_contacto'] ?? null;
        $contenido = trim($datos['contenido'] ?? '');

        // Validar los datos obligatorios
        if (
            !filter_var($idCurso, FILTER_VALIDATE_INT) ||
            $idCurso <= 0 ||
            !filter_var($idContacto, FILTER_VALIDATE_INT) ||
            $idContacto <= 0 ||
            $contenido === ''
        ) {
            $this->responder(400, [
                'error' => 'Debes proporcionar un curso, un contacto y un mensaje válido.'
            ]);
        }

        // Evitar enviarse mensajes a sí mismo
        if ((int) $idContacto === (int) $_SESSION['user_id']) {
            $this->responder(400, [
                'error' => 'No puedes enviarte mensajes a ti mismo.'
            ]);
        }

        // Validar la longitud del mensaje
        if (mb_strlen($contenido) > 10000) {
            $this->responder(400, [
                'error' => 'El mensaje no puede superar los 10000 caracteres.'
            ]);
        }

        try {
            $modelo = new Mensaje();

            $resultado = $modelo->enviar(
                (int) $idCurso,
                (int) $_SESSION['user_id'],
                (int) $idContacto,
                $contenido
            );

            $this->responder(201, [
                'mensaje' => 'Mensaje enviado correctamente.',
                'datos' => $resultado
            ]);

        } catch (\Throwable $e) {
            error_log('Error al enviar mensaje: ' . $e->getMessage());

            $this->responder(400, [
                'error' => 'No fue posible enviar el mensaje. Verifica que el contacto y el curso sean válidos.'
            ]);
        }
    }

    // 2. Obtener mensajes de una conversación
    public function obtenerMensajes()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->responder(405, [
                'error' => 'Método no permitido.'
            ]);
        }

        if (
            !isset($_SESSION['user_id'], $_SESSION['rol']) ||
            !in_array($_SESSION['rol'], ['estudiante', 'instructor'])
        ) {
            $this->responder(403, [
                'error' => 'No tienes permiso para consultar mensajes.'
            ]);
        }

        $idCurso = $_GET['id_curso'] ?? null;
        $idContacto = $_GET['id_contacto'] ?? null;

        if (
            !filter_var($idCurso, FILTER_VALIDATE_INT) ||
            $idCurso <= 0 ||
            !filter_var($idContacto, FILTER_VALIDATE_INT) ||
            $idContacto <= 0
        ) {
            $this->responder(400, [
                'error' => 'Debes proporcionar un curso y un contacto válidos.'
            ]);
        }

        if ((int) $idContacto === (int) $_SESSION['user_id']) {
            $this->responder(400, [
                'error' => 'El contacto no es válido.'
            ]);
        }

        try {
            $modelo = new Mensaje();

            $mensajes = $modelo->obtenerMensajes(
                (int) $idCurso,
                (int) $_SESSION['user_id'],
                (int) $idContacto
            );

            $this->responder(200, [
                'mensajes' => $mensajes
            ]);

        } catch (\Throwable $e) {
            error_log('Error al obtener mensajes: ' . $e->getMessage());

            $this->responder(500, [
                'error' => 'No fue posible obtener los mensajes.'
            ]);
        }
    }

    // 3. Obtener todas las conversaciones del usuario
    public function obtenerConversaciones()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->responder(405, [
                'error' => 'Método no permitido.'
            ]);
        }

        if (
            !isset($_SESSION['user_id'], $_SESSION['rol']) ||
            !in_array($_SESSION['rol'], ['estudiante', 'instructor'])
        ) {
            $this->responder(403, [
                'error' => 'No tienes permiso para consultar conversaciones.'
            ]);
        }

        try {
            $modelo = new Mensaje();

            $conversaciones = $modelo->obtenerConversaciones(
                (int) $_SESSION['user_id']
            );

            $this->responder(200, [
                'conversaciones' => $conversaciones
            ]);

        } catch (\Throwable $e) {
            error_log('Error al obtener conversaciones: ' . $e->getMessage());

            $this->responder(500, [
                'error' => 'No fue posible obtener las conversaciones.'
            ]);
        }
    }

    // 4. Responder con JSON
    private function responder($codigo, $datos)
    {
        http_response_code($codigo);
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
