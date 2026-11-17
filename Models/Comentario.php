<?php

namespace Models;

use Core\App;
use Core\Database;

class Comentario
{
    private $tabla = 'comentarios';
    private $conn;

    public function __construct()
    {
        $this->conn = App::resolve(Database::class);
    }

    // Registrar comentario mediante stored procedure
    public function registrar($datos)
    {
        $sql = "CALL sp_comentarios(
            :opcion,
            :id_comentario,
            :id_usuario,
            :id_curso,
            :comentario
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 1,
            'id_comentario' => null,
            'id_usuario' => $datos['id_usuario'],
            'id_curso' => $datos['id_curso'],
            'comentario' => $datos['comentario']
        ]);

        $respuesta = $resultado->first();

        // Liberar resultados pendientes
        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados
        }

        return $respuesta;
    }

    // Obtener comentarios de un curso
    public function obtenerPorCurso($id_curso)
    {
        $sql = "CALL sp_comentarios(
            :opcion,
            :id_comentario,
            :id_usuario,
            :id_curso,
            :comentario
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 2,
            'id_comentario' => null,
            'id_usuario' => null,
            'id_curso' => $id_curso,
            'comentario' => null
        ]);

        $comentarios = $resultado->get();

        // Liberar resultados pendientes
        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados
        }

        return $comentarios;
    }

    // Eliminar comentario lógicamente
    public function eliminar($id_comentario)
    {
        $sql = "CALL sp_comentarios(
            :opcion,
            :id_comentario,
            :id_usuario,
            :id_curso,
            :comentario
        )";

        $this->conn->query($sql, [
            'opcion' => 3,
            'id_comentario' => $id_comentario,
            'id_usuario' => null,
            'id_curso' => null,
            'comentario' => null
        ]);

        // Liberar resultados pendientes
        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados
        }

        return true;
    }
}
