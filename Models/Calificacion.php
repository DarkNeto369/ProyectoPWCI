<?php

namespace Models;

use Core\App;
use Core\Database;

class Calificacion
{
    private $tabla = 'calificaciones';
    private $conn;

    public function __construct()
    {
        $this->conn = App::resolve(Database::class);
    }

    // Registrar calificacion mediante stored procedure
    public function registrar($datos)
    {
        $sql = "CALL sp_calificaciones(
            :opcion,
            :id_usuario,
            :id_curso,
            :calificacion
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 1,
            'id_usuario' => $datos['id_usuario'],
            'id_curso' => $datos['id_curso'],
            'calificacion' => $datos['calificacion']
        ]);

        $respuesta = $resultado->first();

        // Liberar resultados pendientes
        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados
        }

        return $respuesta;
    }

    // Obtener promedio de calificaciones de un curso
    public function obtenerPromedio($id_curso)
    {
        $sql = "CALL sp_calificaciones(
            :opcion,
            :id_usuario,
            :id_curso,
            :calificacion
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 2,
            'id_usuario' => null,
            'id_curso' => $id_curso,
            'calificacion' => null
        ]);

        $promedio = $resultado->first();

        // Liberar resultados pendientes
        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados
        }

        return $promedio;
    }
}