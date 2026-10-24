<?php

namespace Models;

use Core\App;
use Core\Database;

class Curso
{
    private $tabla = 'cursos';
    private $conn;

    public function __construct()
    {
        $this->conn = App::resolve(Database::class);
    }

    // Agregar curso mediante el stored procedure
    public function agregar($datos)
    {
        $sql = "CALL sp_cursos(
            :opcion,
            :id_curso,
            :id_instructor,
            :id_usuario,
            :categoria,
            :titulo,
            :descripcion,
            :costo,
            :imagen
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 1,
            'id_curso' => null,
            'id_instructor' => $datos['id_instructor'] ?? null,
            'id_usuario' => null,
            'categoria' => $datos['categoria'] ?? null,
            'titulo' => $datos['titulo'] ?? null,
            'descripcion' => $datos['descripcion'] ?? null,
            'costo' => $datos['costo'] ?? null,
            'imagen' => $datos['imagen'] ?? null
        ]);

        $curso = $resultado->first();

        // Liberar los resultados pendientes del procedimiento
        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados
        }

        return $curso;
    }

    // Recuperar los cursos recientes
    public function obtenerRecientes()
    {
        $sql = "CALL sp_cursos(
            :opcion,
            :id_curso,
            :id_instructor,
            :id_usuario,
            :categoria,
            :titulo,
            :descripcion,
            :costo,
            :imagen
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 2,
            'id_curso' => null,
            'id_instructor' => null,
            'id_usuario' => null,
            'categoria' => null,
            'titulo' => null,
            'descripcion' => null,
            'costo' => null,
            'imagen' => null
        ]);

        $cursos = $resultado->get();

        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados pendientes
        }

        return $cursos;
    }

    // Recuperar los cursos de un instructor
    public function obtenerPorInstructor($id_instructor)
    {
        $sql = "CALL sp_cursos(
            :opcion,
            :id_curso,
            :id_instructor,
            :id_usuario,
            :categoria,
            :titulo,
            :descripcion,
            :costo,
            :imagen
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 3,
            'id_curso' => null,
            'id_instructor' => $id_instructor,
            'id_usuario' => null,
            'categoria' => null,
            'titulo' => null,
            'descripcion' => null,
            'costo' => null,
            'imagen' => null
        ]);

        $cursos = $resultado->get();

        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados pendientes
        }

        return $cursos;
    }

    // Recuperar el detalle de un curso y sus niveles
    public function obtenerDetalle($id_curso)
    {
        $sql = "CALL sp_cursos(
            :opcion,
            :id_curso,
            :id_instructor,
            :id_usuario,
            :categoria,
            :titulo,
            :descripcion,
            :costo,
            :imagen
        )";

        $resultado = $this->conn->query($sql, [
            'opcion' => 4,
            'id_curso' => $id_curso,
            'id_instructor' => null,
            'id_usuario' => null,
            'categoria' => null,
            'titulo' => null,
            'descripcion' => null,
            'costo' => null,
            'imagen' => null
        ]);

        // Primer resultado: datos generales del curso
        $curso = $resultado->first();

        // Segundo resultado: niveles del curso
        $niveles = [];

        if ($this->conn->statement->nextRowset()) {
            $niveles = $this->conn->statement->fetchAll(
                \PDO::FETCH_ASSOC
            );
        }

        // Liberar cualquier resultado pendiente
        while ($this->conn->statement->nextRowset()) {
            // Consumir resultados
        }

        return [
            'curso' => $curso,
            'niveles' => $niveles
        ];
    }
}