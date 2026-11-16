<?php

namespace Models;

use Core\App;
use Core\Database;

class Mensaje
{
    private $tabla = 'mensajes';
    private $conn;

    public function __construct()
    {
        $this->conn = App::resolve(Database::class);
    }

    // Enviar un mensaje mediante el stored procedure
    public function enviar($idCurso, $idUsuario, $idContacto, $contenido)
    {
        $sql = "CALL sp_mensajes(
            :opcion,
            :id_curso,
            :id_usuario,
            :id_contacto,
            :contenido
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 1,
            'id_curso' => $idCurso,
            'id_usuario' => $idUsuario,
            'id_contacto' => $idContacto,
            'contenido' => $contenido
        ]);

        $mensaje = $resultado->first();

        // Liberar los resultados pendientes del procedimiento
        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados
        }

        return $mensaje;
    }

    // Obtener los mensajes de una conversación
    public function obtenerMensajes($idCurso, $idUsuario, $idContacto)
    {
        $sql = "CALL sp_mensajes(
            :opcion,
            :id_curso,
            :id_usuario,
            :id_contacto,
            :contenido
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 2,
            'id_curso' => $idCurso,
            'id_usuario' => $idUsuario,
            'id_contacto' => $idContacto,
            'contenido' => null
        ]);

        $mensajes = $resultado->get();

        // Liberar los resultados pendientes del procedimiento
        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados
        }

        return $mensajes;
    }

    // Obtener las conversaciones del usuario
    public function obtenerConversaciones($idUsuario)
    {
        $sql = "CALL sp_mensajes(
            :opcion,
            :id_curso,
            :id_usuario,
            :id_contacto,
            :contenido
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 3,
            'id_curso' => null,
            'id_usuario' => $idUsuario,
            'id_contacto' => null,
            'contenido' => null
        ]);

        $conversaciones = $resultado->get();

        // Liberar los resultados pendientes del procedimiento
        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados
        }

        return $conversaciones;
    }
}